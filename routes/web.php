<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController; // <-- sudah ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    ->prefix('masterdashboard')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen user - daftarkan create & store juga
        Route::resource('/users', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });

require __DIR__ . '/auth.php';
