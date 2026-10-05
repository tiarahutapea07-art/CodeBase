<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('dashboard.index', compact(
            'products',
            'totalProducts',
            'totalValue'
        ));
    }

    // HALAMAN DATA BARANG (Kelola CRUD)
    public function index()
    {
        $products = Product::with('user')->latest()->get();

        return view('products.index', compact('products'));
    }

    // TAMBAH BARANG
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar dari laptop
        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')
                ->store('products', 'public');
        }

        // Menyimpan ID user yang menambahkan barang
        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    // EDIT DATA
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    // UPDATE BARANG
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Kalau user memilih gambar baru
        if ($request->hasFile('image_url')) {

            // Hapus gambar lama
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            // Simpan gambar baru
            $validated['image_url'] = $request->file('image_url')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    // HAPUS BARANG
    public function destroy(Product $product)
    {
        // Hapus file gambar
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}