<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    protected string $cacheKeyList = 'product_cache_keys';

    public function __construct(protected Product $product) {}

    public function getFilteredProducts(array $filters, $perPage, $page): LengthAwarePaginator
    {
        $user = Auth::user();

        $cacheKey = 'products:'.md5(json_encode([
            'filters' => $filters,
            'page'    => $page,
            'perPage' => $perPage,
            'user_id' => $user->id,
        ]));

        $this->storeCacheKey($cacheKey);

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filters, $user, $perPage, $page) {
            return $this->product->query()
                ->where('user_id', $user->id)
                ->when(isset($filters['search']), function ($query) use ($filters) {
                    $query->where('name', 'like', "%{$filters['search']}%")
                        ->orWhere('description', 'like', "%{$filters['search']}%");
                })
                ->when(isset($filters['category']), function ($query) use ($filters) {
                    $query->where('category', $filters['category']);
                })
                ->orderBy($filters['sort_by'] ?? 'id', $filters['sort_direction'] ?? 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
        });
    }

    public function store(array $data): Product
    {
        $user = Auth::user();

        $product = [
            'user_id' => $user->id,
            ...$data,
        ];

        $created = $this->product->create($product);
        if ($created) {
            $this->clearProductCache();
        }

        return $created;
    }

    public function edit(Product $product, array $data): bool
    {
        $updated = $product->update($data);
        if ($updated) {
            $this->clearProductCache();
        }

        return $updated;
    }

    public function destroy(Product $product): bool
    {
        $deleted = $product->delete();
        if ($deleted) {
            $this->clearProductCache();
        }

        return $deleted;
    }

    /**
     * Stores a cache key in the cache key registry.
     *
     * This method adds a new cache key to the list of product cache keys
     * if it doesn't already exist, ensuring we can track and clear all
     * product-related caches when needed.
     *
     * @param string $key The cache key to store
     * @return void
     */
    protected function storeCacheKey(string $key): void
    {
        $keys = Cache::get($this->cacheKeyList, []);

        if (! in_array($key, $keys)) {
            $keys[] = $key;
            Cache::put($this->cacheKeyList, $keys, now()->addMinutes(5));
        }
    }

    /**
     * Clears all product-related cache entries.
     *
     * This method retrieves all the cached product keys from the registry
     * and systematically removes each one from the cache. Finally, it also
     * removes the registry itself to ensure complete cache invalidation.
     *
     * @return void
     */
    protected function clearProductCache(): void
    {
        $keys = Cache::get($this->cacheKeyList, []);

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Cache::forget($this->cacheKeyList);
    }
}
