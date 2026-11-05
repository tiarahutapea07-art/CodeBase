<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;


class ProductController extends Controller
{
    public function home()
    {
        $products = Product::latest()->get();

        return view('welcome', compact('products'));
    }

    // HALAMAN DASHBOARD
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

    // HALAMAN DATA BARANG
    public function index(Request $request)
    {
        $query = Product::with('user')->latest();

        if ($request->filter == 'jual') {
            $query->where('price', '>', 0);
        } elseif ($request->filter == 'donasi') {
            $query->where('price', 0);
        }

        $products = $query->get();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    // TAMBAH BARANG
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:jual,donasi',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required_if:type,jual|nullable|numeric|min:1',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Jika barang donasi, harga otomatis 0
        if ($validated['type'] === 'donasi') {
            $validated['price'] = 0;
        }

        // Simpan gambar langsung ke public/images
        if ($request->hasFile('image')) {
            $imageName = uniqid('product_') . '.' .
                $request->file('image')->extension();

            $request->file('image')->move(
                public_path('images'),
                $imageName
            );

            $validated['image_url'] = 'images/' . $imageName;
        }

        // Hapus field yang bukan kolom tabel products
        unset($validated['image'], $validated['type']);

        $validated['user_id'] = auth()->id();

        Product::create($validated);

        // Pengguna biasa diarahkan ke Barang Saya
        if (auth()->user()->role === 'user') {
            return redirect()
                ->route('my-products.index')
                ->with('success', 'Barang berhasil ditambahkan!');
        }

        // Admin diarahkan ke halaman data barang
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
            'type'        => 'required|in:jual,donasi',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required_if:type,jual|nullable|numeric|min:1',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Jika barang donasi, harga otomatis menjadi 0
        if ($validated['type'] === 'donasi') {
            $validated['price'] = 0;
        }

        // Jika user memilih gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama hasil upload di public/images
            if (
                $product->image_url &&
                str_starts_with($product->image_url, 'images/product_')
            ) {
                $oldImage = public_path($product->image_url);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // Hapus gambar lama dari penyimpanan versi sebelumnya
            elseif (
                $product->image_url &&
                str_starts_with($product->image_url, 'products/')
            ) {
                Storage::disk('public')->delete($product->image_url);
            }

            // Simpan gambar baru ke public/images
            $imageName = uniqid('product_') . '.' .
                $request->file('image')->extension();

            $request->file('image')->move(
                public_path('images'),
                $imageName
            );

            $validated['image_url'] = 'images/' . $imageName;
        }

        // Hapus field yang bukan kolom tabel products
        unset($validated['type'], $validated['image']);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    // HAPUS BARANG
    public function destroy(Product $product)
    {
        // Hapus gambar hasil upload di public/images
        if (
            $product->image_url &&
            str_starts_with($product->image_url, 'images/product_')
        ) {
            $imagePath = public_path($product->image_url);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus gambar lama dari penyimpanan versi sebelumnya
        elseif (
            $product->image_url &&
            str_starts_with($product->image_url, 'products/')
        ) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    // DETAIL BARANG
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    // FORM TAMBAH BARANG
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }
}