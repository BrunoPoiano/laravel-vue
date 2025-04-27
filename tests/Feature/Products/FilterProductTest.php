<?php

use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;

test('product service caches filtered results', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $service = new ProductService(new Product);
    $filters = ['search' => 'test'];

    $perPage = 5;
    $page    = 1;

    $result1 = $service->getFilteredProducts($filters, $perPage, $page, $user->id);
    $result2 = $service->getFilteredProducts($filters, $perPage, $page, $user->id);

    $cacheKey = 'products:'.md5(json_encode([
        'filters' => $filters,
        'page'    => $page,
        'perPage' => $perPage,
        'user_id' => $user->id,
    ]));

    expect(Cache::has($cacheKey))->toBeTrue();
    expect($result1)->toEqual($result2);
});
