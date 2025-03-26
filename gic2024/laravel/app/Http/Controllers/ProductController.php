<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // --- Get /api/products
    public function getProducts() {
        try {
            $products = Product::with('category')->get();
            return response()->json(['data' => $products], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch products'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Post /api/products
    public function createProduct(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'pricing' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'images' => 'nullable|json'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $product = Product::create([
                'name' => $request->name,
                'pricing' => $request->pricing,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'images' => $request->images
            ]);

            return response()->json(['data' => $product], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create product',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Get /api/products/{productId}
    public function getProduct($productId) {
        try {
            $product = Product::with('category')->find($productId);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['data' => $product], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Patch /api/products/{productId}
    public function updateProduct(Request $request, $productId) {
        try {
            $product = Product::find($productId);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'pricing' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'images' => 'nullable|json'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $product->update([
                'name' => $request->name,
                'pricing' => $request->pricing,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'images' => $request->images
            ]);

            return response()->json(['data' => $product], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Delete /api/products/{productId}
    public function deleteProduct($productId) {
        try {
            $product = Product::find($productId);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }

            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // --- Get /api/categories/{categoryId}/products
    public function getProductsByCategory($categoryId) {
        try {
            $category = Category::findOrFail($categoryId);
            
            $products = Product::where('category_id', $categoryId)->get();
            
            return response()->json(['data' => $products], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch products: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch products'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}