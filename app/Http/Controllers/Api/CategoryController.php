<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\IndexCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\DestroyCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(IndexCategoryRequest $request)
    {
        $categories = Category::with('products')->get();
        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json($category, 201);
    }

    public function show(ShowCategoryRequest $request, Category $category)
    {
        return response()->json($category->load('products'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json($category);
    }

    public function destroy(DestroyCategoryRequest $request, Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
