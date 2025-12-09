<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (bebas diakses)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard user (butuh login & email terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (FRONTEND USER) - TANPA LOGIN
|--------------------------------------------------------------------------
|
| Produk, keranjang, dan checkout bisa diakses tanpa auth.
| Kalau nanti mau wajib login, baru dibungkus middleware('auth').
|
*/

// daftar produk
Route::get('/produk', [ShopController::class, 'index'])->name('shop.index');

// halaman keranjang
Route::get('/keranjang', [ShopController::class, 'cart'])->name('shop.cart');

// tambah ke keranjang
Route::post('/keranjang/tambah/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');

// hapus dari keranjang
Route::delete('/keranjang/hapus/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

// checkout sederhana
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (BUTUH LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| Semua route admin membutuhkan auth + admin role
|
*/

Route::middleware(['auth', 'admin'])
    ->prefix('masterdashboard')   // URL: /masterdashboard/...
    ->name('admin.')              // Nama route: admin.*
    ->group(function () {

        // Dashboard admin
        // URL: /masterdashboard
        // Name: admin.dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen user
        // URL dasar: /masterdashboard/users
        // Nama route: admin.users.index, admin.users.create, dst.
        Route::resource('users', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Manajemen produk (CRUD lengkap)
        // URL dasar: /masterdashboard/products
        // Nama route: admin.products.index, admin.products.create, admin.products.store, admin.products.edit, admin.products.update, admin.products.destroy, admin.products.show
        Route::resource('products', ProductController::class);
    });

require __DIR__.'/auth.php';
