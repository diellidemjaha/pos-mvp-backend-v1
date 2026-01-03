<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $q = \App\Models\Product::query()->orderBy('name');

    if ($request->filled('category_id')) {
        $q->where('category_id', $request->category_id);
    }

    return $q->get();
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $product = Product::create([
         'sku' => 'SKU-' . strtoupper(uniqid()),
        'name'        => $data['name'],
        'price'       => $data['price'],
        'stock'       => $data['stock'],
        'category_id' => $data['category_id'] ?? null,
    ]);

    return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
        ]);

        $product->update($data);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
