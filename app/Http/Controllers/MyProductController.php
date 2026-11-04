<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MyProductController extends Controller
{
    // Memastikan hanya pengguna biasa
    private function checkUser()
    {
        abort_unless(
            auth()->user()->role === 'user',
            403,
            'Akses hanya untuk Pengguna'
        );
    }

    // Mengambil barang berdasarkan pemiliknya
    private function myProduct($id)
    {
        return auth()->user()
            ->products()
            ->findOrFail($id);
    }

    // HALAMAN BARANG SAYA
    public function index()
    {
        $this->checkUser();

        $products = auth()->user()
            ->products()
            ->with('category')
            ->latest()
            ->get();

        $totalProducts = $products->count();

        return view('users.my-products', compact(
            'products',
            'totalProducts'
        ));
    }

    // HALAMAN EDIT BARANG
    public function edit($id)
    {
        $this->checkUser();

        $product = $this->myProduct($id);

        $categories = Category::orderBy('name')->get();

        return view('users.edit-product', compact(
            'product',
            'categories'
        ));
    }

    // UPDATE BARANG
    public function update(Request $request, $id)
    {
        $this->checkUser();

        $product = $this->myProduct($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:jual,donasi',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required_if:type,jual|nullable|numeric|min:1',
            'condition'   => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validated['type'] === 'donasi') {
            $validated['price'] = 0;
        }

        if ($request->hasFile('image')) {

            if (
                $product->image_url &&
                str_starts_with($product->image_url, 'products/')
            ) {
                Storage::disk('public')->delete($product->image_url);
            }

            $validated['image_url'] = $request->file('image')
                ->store('products', 'public');
        }

        unset($validated['type'], $validated['image']);

        $product->update($validated);

        return redirect()
            ->route('my-products.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    // HAPUS BARANG
    public function destroy($id)
    {
        $this->checkUser();

        $product = $this->myProduct($id);

        if (
            $product->image_url &&
            str_starts_with($product->image_url, 'products/')
        ) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()
            ->route('my-products.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    

}
