<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getFilteredProducts(array $filters): LengthAwarePaginator;

    public function store(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function delete(Product $product): bool;
}
