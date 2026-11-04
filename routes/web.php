
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomingGoodController;
use App\Http\Controllers\OutgoingGoodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NegotiationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MyProductController;


/*
|--------------------------------------------------------------------------
| HOMEPAGE PUBLIK
|--------------------------------------------------------------------------
*/

// Pengunjung bisa melihat katalog tanpa login
Route::get('/', [ProductController::class, 'home'])
    ->name('home');

// URL beranda lama diarahkan ke homepage
Route::get('/beranda', function () {
    return redirect()->route('home');
})->name('beranda');


Route::middleware(['auth'])->group(function () {
    // WAJIB PALING ATAS
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Rute lain yang pakai parameter taruh di bawahnya
    Route::get('/products/{id}', [ProductController::class, 'show']);
});


/*
|--------------------------------------------------------------------------
| LOGIN DAN REGISTER
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login pengguna
    Route::get('/masuk', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/masuk', [AuthController::class, 'login'])
        ->name('login.process');

    // Registrasi pengguna
    Route::get('/daftar', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/daftar', [AuthController::class, 'register'])
        ->name('register.process');

    // Login admin
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])
        ->name('admin.login');

    Route::post('/admin/login', [AuthController::class, 'adminLogin'])
        ->name('admin.login.process');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/keluar', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {


    // CRUD produk
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    // CRUD barang masuk
    Route::resource('incoming-goods', IncomingGoodController::class);

    // CRUD barang keluar
    Route::resource('outgoing-goods', OutgoingGoodController::class);

    // CRUD pengguna
    Route::resource('users', UserController::class);


});


/*
|--------------------------------------------------------------------------
| NEGOSIASI
|--------------------------------------------------------------------------
*/

// Semua fitur negosiasi wajib login
Route::middleware('auth')->group(function () {

    Route::get('/nego', [NegotiationController::class, 'index'])
        ->name('negotiations.index');

    Route::post('/products/{product}/nego', [NegotiationController::class, 'store'])
        ->name('negotiations.store');

    Route::patch('/nego/{negotiation}/respond', [NegotiationController::class, 'respond'])
        ->name('negotiations.respond');

    Route::patch('/nego/{negotiation}/reply', [NegotiationController::class, 'reply'])
        ->name('negotiations.reply');
});


/*
|--------------------------------------------------------------------------
| DETAIL PRODUK PUBLIK
|--------------------------------------------------------------------------
*/

// Detail produk bisa dilihat tanpa login
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');


    Route::middleware(['auth'])->group(function () {
    // 1. Inbox & Kirim Pesan Teks
    Route::get('/inbox', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // 2. TAMBAHKAN INI: Memulai/Membuka Chat dari Halaman Produk
    Route::post('/chat/start/{productId}', [ChatController::class, 'startConversation'])->name('chat.start');

    // 3. TAMBAHKAN INI: Menampilkan Halaman Ruang Obrolan Detail
    Route::get('/chat/{id}', [ChatController::class, 'showChat'])->name('chat.show');

    // 4. TAMBAHKAN INI: Mengirim Penawaran Harga (Nego)
    Route::post('/chat/{id}/offer', [ChatController::class, 'sendOffer'])->name('chat.offer');

    // 5. TAMBAHKAN INI: Penjual Terima / Tolak Tawaran
    Route::post('/offer/{messageId}/status', [ChatController::class, 'updateOfferStatus'])->name('offer.status');
});

// PROFILE
Route::middleware(['auth'])->group(function () {

    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

});

// DASHBOARD BERDASARKAN JENIS AKUN
Route::middleware(['auth'])->group(function () {

    // Pengarah dashboard sesuai jenis akun
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Dashboard Admin
    Route::get('/admin/dashboard', [ProductController::class, 'dashboard'])
    ->middleware('admin')
    ->name('admin.dashboard');

    // Dashboard Pengguna
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

});

// FITUR FAVORIT
Route::middleware(['auth'])->group(function () {
    Route::get('/favorit', [FavoriteController::class, 'index'])
        ->name('favorites.index');

    Route::post('/favorit/{product}', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
});

// BARANG SAYA - KHUSUS PENGGUNA
Route::middleware(['auth'])->group(function () {

    Route::get('/barang-saya', [MyProductController::class, 'index'])
        ->name('my-products.index');

    Route::get('/barang-saya/{id}/edit', [MyProductController::class, 'edit'])
        ->name('my-products.edit');

    Route::put('/barang-saya/{id}', [MyProductController::class, 'update'])
        ->name('my-products.update');

    Route::delete('/barang-saya/{id}', [MyProductController::class, 'destroy'])
        ->name('my-products.destroy');

});