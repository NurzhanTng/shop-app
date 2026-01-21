<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getAllProducts(array $filters = []): LengthAwarePaginator
    {
        $query = Product::with('category');

        // Фильтр по категории
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Поиск по названию
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate(12);
    }

    public function getProduct(int $id): ?Product
    {
        return Product::with('category')->find($id);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
}