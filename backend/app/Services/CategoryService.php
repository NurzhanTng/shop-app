<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }

    public function deleteCategory(Category $category): bool
    {
        // Проверяем, есть ли товары в категории
        if ($category->products()->count() > 0) {
            throw new \Exception('Cannot delete category with products');
        }
        
        return $category->delete();
    }
}