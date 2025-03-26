<?php

namespace App\Http\Controllers;

use \App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories() {
        return Category::all();
    }

    // --- Post /api/categories
    public function createCategory(Request $request) {
        $category = new Category;
        $category->name = $request->name;
        $category->save();
        return $category;    
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId) {
        $category = Category::find($categoryId);
        return $category;   
    }

    // --- Patch /api/categories/{categoryId}
    public function updateCategory(Request $request, $categoryId) {
        $category = Category::find($categoryId);
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId) {
        $category = Category::find($categoryId);
        $category->delete();
        return $category;
    }
}