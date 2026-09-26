<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 1. Alamat Utama (http://127.0.0.1:8000) -> Menampilkan Web ReUseMarket User
Route::get('/', [ProductController::class, 'home'])->name('home');

// 2. Alamat Admin (http://127.0.0.1:8000/dashboard) -> Menampilkan Dashboard Admin
Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

// Rute CRUD Produk
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');