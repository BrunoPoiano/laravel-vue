<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Service class for handling Product-related business logic with caching support.
 * Manages CRUD operations and filtered queries for products while maintaining
 * a cache system to improve performance.
 */
class ProductService
{
    /**
     * Key used to store the list of all product-related cache keys.
     * This registry helps in tracking and invalidating all product caches.
     */
    protected string $cacheKeyList = 'product_cache_keys';

    /**
     * Constructor injection of Product model.
     */
    public function __construct(protected Product $product) {}

    /**
     * Retrieves a filtered and paginated list of products for the authenticated user.
     * Implements caching to improve performance of frequently accessed product lists.
     *
     * @param array $filters      Array of filters including: search, sort_by, sort_direction
     * @param int   $perPage     Number of items per page
     * @param int   $page        Current page number
     * @return LengthAwarePaginator Paginated collection of filtered products
     */
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
                ->orderBy($filters['sort_by'] ?? 'id', $filters['sort_direction'] ?? 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
        });
    }

    /**
     * Creates a new product associated with the authenticated user.
     * Automatically invalidates product cache after successful creation.
     *
     * @param array $data Product data including name, description, price, quantity
     * @return Product   The newly created product instance
     */
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

    /**
     * Updates an existing product with new data.
     * Automatically invalidates product cache after successful update.
     *
     * @param Product $product The product instance to update
     * @param array   $data    New product data
     * @return bool           True if update was successful
     */
    public function edit(Product $product, array $data): bool
    {
        $updated = $product->update($data);
        if ($updated) {
            $this->clearProductCache();
        }

        return $updated;
    }

    /**
     * Deletes a product from the database.
     * Automatically invalidates product cache after successful deletion.
     *
     * @param Product $product The product instance to delete
     * @return bool           True if deletion was successful
     */
    public function destroy(Product $product): bool
    {
        $deleted = $product->delete();
        if ($deleted) {
            $this->clearProductCache();
        }

        return $deleted;
    }

    /**
     * Internal method to store a cache key in the registry.
     * Ensures we can track and clear all product-related caches when needed.
     *
     * @param string $key The cache key to store in registry
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
     * Internal method to clear all product-related cache entries.
     * Removes all tracked cache keys and the registry itself.
     * Called automatically after any product modification operation.
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
