<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomingGoodController;
use App\Http\Controllers\OutgoingGoodController;
use App\Http\Controllers\UserController;


// Publik: katalog ada di beranda
Route::get('/', [ProductController::class, 'home'])->name('home');

// Hanya admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    // Kelola data barang (CRUD)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // --- TAMBAHAN CRUD BARU DI SINI ---
    Route::resource('incoming-goods', IncomingGoodController::class);
    Route::resource('outgoing-goods', OutgoingGoodController::class);
    Route::resource('users', UserController::class);
});

Route::middleware('guest')->group(function () {
    Route::get('/masuk',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login']);

    Route::get('/daftar',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);

    Route::get('/admin/login',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);
});

Route::post('/keluar', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('dashboard.index'))->name('dashboard');
});

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');