<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\ShowProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\DestroyProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(IndexProductRequest $request)
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    public function show(ShowProductRequest $request, Product $product)
    {
        return response()->json($product->load('category'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product);
    }

    public function destroy(DestroyProductRequest $request, Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
