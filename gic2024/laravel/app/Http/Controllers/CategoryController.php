<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories(){
        return Category::all();
    }

    // --- Post /api/categories
    public function createCategory(){
        return ["message" => "Creating 1 new category"];
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId){
        return ["message" => "Getting 1 category base on given categoryId"];
    }    
    
    // --- Patch /api/categories/{categoryId}
    public function updateCategory($categoryId){
        return ["message" => "Updating 1 category base on given categoryId"];
    }
    
    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId){
        return ["message" => "Deleting 1 category base on given categoryId"];
    }
}