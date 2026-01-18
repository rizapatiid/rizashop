<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\Admin\RevenueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// halaman utama dashboard user
Route::get('/', [HomeDashboardController::class, 'index'])->name('dashboard');

// fallback dashboard
Route::get('/dashboard', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (FRONTEND)
|--------------------------------------------------------------------------
*/
Route::get('/produk', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/keranjang', [ShopController::class, 'cart'])->name('shop.cart');
Route::post('/keranjang/tambah/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');
Route::delete('/keranjang/hapus/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

Route::patch('/keranjang/item', [ShopController::class, 'updateItem'])->name('shop.cart.update');
Route::delete('/keranjang/item', [ShopController::class, 'deleteItem'])->name('shop.cart.delete');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | PROFILE
    */
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/account/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | CHECKOUT
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/start', [CheckoutController::class, 'start'])->name('checkout.start');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::post('/checkout/clear', [CheckoutController::class, 'clear'])->name('checkout.clear');

    /*
    | PAYMENTS
    */
    Route::get('/payments/{order}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{order}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{order}', [PaymentController::class, 'show'])->name('payments.show');

    /*
    | ORDERS (USER)
    */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/receive', [OrderController::class, 'receive'])->name('orders.receive');

    /*
    | ADDRESSES (FIXED – NO DUPLICATE ROUTES)
    */
    Route::resource('addresses', AddressController::class)
        ->except(['create', 'show']);

    Route::prefix('addresses')->name('addresses.')->group(function () {

        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::patch('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');

        // ✅ SATU-SATUNYA set primary (TIDAK DUPLIKAT)
        Route::patch('/{address}/primary', [AddressController::class, 'setPrimary'])
            ->name('setPrimary');
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
        Route::resource('banners', BannerController::class);

        Route::get('/pendapatan', [RevenueController::class, 'index'])
            ->name('revenue.index');

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::post('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{order}/set-tracking', [AdminOrderController::class, 'setTracking'])->name('setTracking');
        });
    });

require __DIR__ . '/auth.php';