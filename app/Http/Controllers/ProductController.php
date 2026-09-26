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

    public function index()
    {
        $products = Product::with('user')->latest()->get();
        $totalProducts = Product::count();
        $totalValue = Product::sum('price');

        return view('dashboard.index', compact('products', 'totalProducts', 'totalValue'));
    }

    // SIMPAN BARANG BARU (CREATE)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
        ]);

        // Sementara di-set user_id = 1 (Ganti sesuai kebutuhan auth)
        $validated['user_id'] = 1;

        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil ditambahkan!');
    }

    // AMBIL DATA KETIKA EDIT (READ UPDATE DATA)
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    // UPDATE DATA BARANG (UPDATE)
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

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diperbarui!');
    }

    // HAPUS BARANG (DELETE)
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus!');
    }
}