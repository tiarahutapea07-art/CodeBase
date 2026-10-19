
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomingGoodController;
use App\Http\Controllers\OutgoingGoodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NegotiationController;

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

    // Dashboard admin
    Route::get('/dashboard', [ProductController::class, 'dashboard'])
        ->name('dashboard');

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

    // URL dashboard admin alternatif: /admin
    Route::get('/admin', [ProductController::class, 'dashboard'])
        ->name('admin.dashboard');
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
