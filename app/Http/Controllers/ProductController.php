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
    public function index(Request $request)
    {
        $query = Product::with('user')->latest();

        if ($request->filter == 'jual') {
            $query->where('price', '>', 0);
        } elseif ($request->filter == 'donasi') {
            $query->where('price', 0);
        }

        $products = $query->get();

        // Mengambil daftar kategori barang
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

        // Upload gambar dari laptop
        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')
                ->store('products', 'public');
        }

        // Menghapus field yang tidak ada di tabel products
        unset($validated['image'], $validated['type']);

        // Menyimpan ID user
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

            // Hapus gambar lama jika tersimpan di folder products
            if ($product->image_url && str_starts_with($product->image_url, 'products/')) {
                Storage::disk('public')->delete($product->image_url);
            }

            // Simpan gambar baru
            $validated['image_url'] = $request->file('image')
                ->store('products', 'public');
        }

        // Hapus type dan image karena bukan kolom tabel products
        unset($validated['type'], $validated['image']);

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

    public function show($id)
    {
        // Mengambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Mengembalikan view detail barang dengan membawa data produk
        return view('products.show', compact('product'));

        
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    
}
