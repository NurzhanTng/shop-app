<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'search']);
        $products = $this->productService->getAllProducts($filters);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('category'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->updateProduct($product, $request->validated());

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete product with existing orders'
            ], 422);
        }

        $this->productService->deleteProduct($product);

        return response()->json(['message' => 'Product deleted successfully']);
    }
}