<?php

use App\Http\Middleware\JwtAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login'); // Redirect ke halaman login
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::controller(WebAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.post');
    });
});

// Authenticated Routes
Route::middleware(JwtAuth::class)->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');

    // // Barang Keluar Routes
    // Route::prefix('barang-keluar')->group(function () {
    //     Route::get('/', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    //     Route::post('/', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    //     Route::get('/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
    //     Route::get('/{id}', [BarangKeluarController::class, 'show'])->name('barang-keluar.show');
    //     Route::put('/{id}', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
    //     Route::delete('/{id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');
    //     Route::get('/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barang-keluar.edit');
    // });

    // Satuan Routes
    Route::prefix('satuan')->group(function () {
        Route::get('/', [SatuanController::class, 'index'])->name('satuan.index');
        Route::post('/', [SatuanController::class, 'store'])->name('satuan.store');
        Route::get('/create', [SatuanController::class, 'create'])->name('satuan.create');
        Route::get('/{satuan}', [SatuanController::class, 'show'])->name('satuan.show');
        Route::put('/{satuan}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/{satuan}', [SatuanController::class, 'destroy'])->name('satuan.destroy');
        Route::get('/{satuan}/edit', [SatuanController::class, 'edit'])->name('satuan.edit');
    });

    // Jenis Barang Routes
    Route::prefix('jenis-barang')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
        Route::post('/', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
        Route::get('/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
        Route::get('/{jenis_barang}', [JenisBarangController::class, 'show'])->name('jenis-barang.show');
        Route::put('/{jenis_barang}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
        Route::delete('/{jenis_barang}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');
        Route::get('/{jenis_barang}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
        Route::get('/updates', [JenisBarangController::class, 'getUpdates'])->name('jenis-barang.updates');
    });
    //Barang Routes
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::post('/create', [BarangController::class, 'create'])->name('barang.create');
        Route::put('/{id}/update', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/{id}/delete', [BarangController::class, 'delete'])->name('barang.delete');
        Route::get('/{id}/barcode', [BarangController::class, 'generateBarcode'])->name('barang.barcode');
        Route::get('/{id}/download-barcode', [BarangController::class, 'downloadBarcode'])->name('barang.download-barcode');
    });
    //Gudang Routes
    Route::prefix('gudang')->group(function () {
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/create', [GudangController::class, 'create'])->name('gudang.create');
        Route::put('/{id}/update', [GudangController::class, 'update'])->name('gudang.update');
        Route::delete('/{id}/delete', [GudangController::class, 'delete'])->name('gudang.delete');
        Route::get('/{id}/barcode', [GudangController::class, 'generateBarcode'])->name('gudang.barcode');
        Route::get('/{id}/download-barcode', [GudangController::class, 'downloadBarcode'])->name('gudang.download-barcode');
    });
    // Logout Route
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
});

// Fallback route
Route::fallback(function () {
    return view('errors.404');
})->name('fallback');
