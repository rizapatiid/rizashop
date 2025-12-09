<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
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

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard user
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (FRONTEND USER)
|--------------------------------------------------------------------------
*/

// daftar produk
Route::get('/produk', [ShopController::class, 'index'])->name('shop.index');

// keranjang
Route::get('/keranjang', [ShopController::class, 'cart'])->name('shop.cart');
Route::post('/keranjang/tambah/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');
Route::delete('/keranjang/hapus/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

// checkout
Route::post('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

/*
|--------------------------------------------------------------------------
| PROFILE + ADDRESS ROUTES (BUTUH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/account/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // resource (index, store, edit, update, destroy)
    Route::resource('addresses', AddressController::class)->except(['create', 'show']);

    // route khusus untuk jadikan utama (POST)
    Route::post('addresses/{address}/set-primary', [AddressController::class, 'setPrimary'])
        ->name('addresses.setPrimary');


        
    // MULTI ADDRESS ROUTES
    Route::prefix('addresses')->name('addresses.')->group(function () {

        // Tambah alamat
        Route::post('/', [AddressController::class, 'store'])->name('store');

        // Update alamat
        Route::patch('/{address}', [AddressController::class, 'update'])->name('update');

        // Hapus alamat
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');

        // Set alamat utama
        Route::patch('/{address}/primary', [AddressController::class, 'setPrimary'])->name('setPrimary');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('masterdashboard')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('products', ProductController::class);
    });

require __DIR__ . '/auth.php';
