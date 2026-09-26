<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::latest()->get();
        return view('welcome', compact('products'));
    }

    // HALAMAN DASHBOARD (Ringkasan Saja)
    public function dashboard()
    {
        $products = Product::with('user')->latest()->get();
        $totalProducts = Product::count();
        $totalValue = Product::sum('price');

        return view('dashboard.index', compact('products', 'totalProducts', 'totalValue'));
    }

    // HALAMAN DATA BARANG (Kelola CRUD)
    public function index()
    {
        $products = Product::with('user')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
        ]);

        $validated['user_id'] = 1;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus!');
    }
}