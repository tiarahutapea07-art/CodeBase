<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses hanya untuk Pengguna');
        }

        $favorites = auth()->user()
            ->favorites()
            ->with('product')
            ->latest()
            ->get();

        $totalFavorites = $favorites->count();

        // Menghitung barang milik pengguna yang sedang login
        $totalProducts = auth()->user()
            ->products()
            ->count();

        $products = auth()->user()
            ->products()
            ->latest()
            ->get();

        return view('users.dashboard', compact(
            'favorites',
            'totalFavorites',
            'totalProducts',
            'products'
        ));
    }
}
