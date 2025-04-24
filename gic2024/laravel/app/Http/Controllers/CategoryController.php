<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use \App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
  
class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories(Request $request)
    {
        $query = Category::query();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
    
        $perPage = $request->input('limit', 10);
        $categories = $query->paginate($perPage);
    
        return response()->json([
            'data' => $categories->items(),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total()
            ]
        ]);
    }

    // --- Post /api/categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'sometimes|string'
        ]);
        
        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId) {
        try {
            $category = Category::find($categoryId);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['data' => $category], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Patch /api/categories/{categoryId}
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$category->id,
            'description' => 'sometimes|string'
        ]);
    
        $category->update($validated);
        return response()->json(['data' => $category]);  // Add data wrapper
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}