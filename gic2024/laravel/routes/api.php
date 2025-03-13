<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function() {
    Route::get('/', 'getcategories');
    Route::post('/', 'createCategory');
    Route::get('/{categoryID}', 'getCategory');
    Route::patch('/{categoryID}', 'updateCategory');
    Route::delete('/{categoryID}', 'deleteCategory');
});

Route::controller(ProductController::class)->prefix('products')->group(function() {
    Route::get('/', 'getProducts');
    Route::post('/', 'createProduct');
    Route::get('/{productID}', 'getProduct');
    Route::patch('/{productID}', 'updateProduct');
    Route::delete('/{productID}', 'deleteProduct');
});