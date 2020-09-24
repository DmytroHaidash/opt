<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categories(): JsonResponse
    {
        return response()->json(CategoryResource::collection(Category::onlyParents('shop')->get()));
    }

    public function subcategories(Category $category): JsonResponse
    {
        return response()->json(CategoryResource::collection($category->children));
    }
}
