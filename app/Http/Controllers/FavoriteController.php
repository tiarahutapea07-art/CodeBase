<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Menampilkan daftar favorit
    public function index()
    {
        $favorites = Auth::user()
            ->favorites()
            ->with('product')
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    // Menambah atau menghapus favorit tanpa refresh
    public function toggle(Request $request, Product $product)
    {
        $favorite = Auth::user()
            ->favorites()
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => true,
                'favorited' => false,
                'message' => 'Produk dihapus dari favorit.',
            ]);
        }

        Auth::user()->favorites()->create([
            'product_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'favorited' => true,
            'message' => 'Produk berhasil ditambahkan ke favorit.',
        ]);
    }
}