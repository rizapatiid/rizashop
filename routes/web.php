<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;

use App\Models\OrderItem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/dashboard', function () {
    return view('welcome');
});

// Dashboard user default (root)
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (FRONTEND USER)
|--------------------------------------------------------------------------
*/

// daftar produk
Route::get('/produk', [ShopController::class, 'index'])->name('shop.index');

// detail produk
Route::get('/produk/{product}', [ShopController::class, 'show'])->name('shop.show');

// keranjang
Route::get('/keranjang', [ShopController::class, 'cart'])->name('shop.cart');

// tambah ke keranjang
Route::post('/keranjang/tambah/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');

// non-AJAX delete (form)
Route::delete('/keranjang/hapus/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

// AJAX endpoints untuk mini-cart / sync
Route::patch('/keranjang/item', [ShopController::class, 'updateItem'])->name('shop.cart.update');
Route::delete('/keranjang/item', [ShopController::class, 'deleteItem'])->name('shop.cart.delete');

// ---------------------------------------------------------

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

    // ============================================
    // CHECKOUT ROUTES (Menggunakan CheckoutController)
    // ============================================
    
    // Halaman checkout (GET) - menampilkan form checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    
    // Start checkout (POST) - menerima selected items dari mini cart
    Route::post('/checkout/start', [CheckoutController::class, 'start'])->name('checkout.start');
    
    // Place order (POST) - proses pembuatan order
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    
    // ============================================

    // payments (user)
    Route::get('/payments/{order}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{order}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{order}', [PaymentController::class, 'show'])->name('payments.show');

    // user orders (frontend)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // user actions on orders
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/receive', [OrderController::class, 'receive'])->name('orders.receive');

    // resource (index, store, edit, update, destroy)
    Route::resource('addresses', AddressController::class)->except(['create', 'show']);

    // route khusus untuk jadikan utama (POST)
    Route::post('addresses/{address}/set-primary', [AddressController::class, 'setPrimary'])
        ->name('addresses.setPrimary');

    // MULTI ADDRESS ROUTES (prefixed 'addresses')
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
    ->prefix('seller')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('products', ProductController::class);

        /*
         * Admin: orders management (masterdashboard/orders...)
         */
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');

            // admin action: update status (confirm payment, proses, selesai, etc)
            Route::post('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');

            // admin action: set tracking / kirimkan (input nomor resi)
            Route::post('/{order}/set-tracking', [AdminOrderController::class, 'setTracking'])->name('setTracking');
        });
    });

require __DIR__ . '/auth.php';