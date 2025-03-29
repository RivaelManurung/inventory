<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::controller(WebAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
    });
});

// Authenticated Routes
Route::middleware(['jwt.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    // Master Data
    Route::prefix('master')->group(function () {
        // Jenis Barang
        Route::resource('jenis-barang', JenisBarangController::class)->except(['show']);
        Route::get('jenis-barang/datatables', [JenisBarangController::class, 'datatables'])
            ->name('jenis-barang.datatables');

        // Satuan
        Route::resource('satuan', SatuanController::class)->except(['show']);
        Route::get('satuan/datatables', [SatuanController::class, 'datatables'])
            ->name('satuan.datatables');

        // Barang
        Route::resource('barang', BarangController::class);
        Route::get('barang/datatables', [BarangController::class, 'datatables'])
            ->name('barang.datatables');
    });
});

// Fallback route
Route::fallback(function () {
    return view('errors.404');
});
