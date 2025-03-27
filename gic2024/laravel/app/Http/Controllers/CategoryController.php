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
    public function getCategories() {
        try {
            $categories = Category::all();
            return response()->json(['data' => $categories], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch categories'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Post /api/categories
    public function createCategory(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $category = Category::create(['name' => $request->name]);
            return response()->json(['data' => $category], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function updateCategory(Request $request, $categoryId) {
        try {
            $category = Category::find($categoryId);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $categoryId
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $category->update(['name' => $request->name]);
            return response()->json(['data' => $category], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId) {
        try {
            $category = Category::find($categoryId);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $category->delete();
            return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}