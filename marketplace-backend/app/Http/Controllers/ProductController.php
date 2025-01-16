<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'user')->paginate(10);
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with('category', 'user')->findOrFail($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product($validated);
        $product->user_id = Auth::id();
        $product->save();

        return response()->json(['message' => 'Product created successfully', 'product' => $product], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
