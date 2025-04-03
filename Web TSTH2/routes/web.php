<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\UserAccessManagementController;
use App\Http\Middleware\JwtAuth;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::controller(WebAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.post');
    });
});

// Authenticated Routes
Route::middleware([JwtAuth::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    // Satuan Routes
    Route::prefix('satuan')->middleware('permission:satuan.view')->group(function () {
        Route::get('/', [SatuanController::class, 'index'])->name('satuan.index');
        Route::middleware('permission:satuan.create')->group(function () {
            Route::post('/', [SatuanController::class, 'store'])->name('satuan.store'); // Changed from create to store
        });
        Route::get('/{satuan}', [SatuanController::class, 'show'])->name('satuan.show');
        Route::middleware('permission:satuan.edit')->group(function () {
            Route::put('/{satuan}', [SatuanController::class, 'update'])->name('satuan.update');
        });
        Route::delete('/{satuan}', [SatuanController::class, 'delete'])
            ->middleware('permission:satuan.delete')
            ->name('satuan.delete');
    });

    // Jenis Barang Routes
    Route::prefix('jenis-barang')->middleware('permission:jenis-barang.view')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
        Route::middleware('permission:jenis-barang.create')->group(function () {
            Route::get('/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
            Route::post('/', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
        });
        Route::get('/{jenis_barang}', [JenisBarangController::class, 'show'])->name('jenis-barang.show');
        Route::middleware('permission:jenis-barang.edit')->group(function () {
            Route::get('/{jenis_barang}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
            Route::put('/{jenis_barang}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
        });
        Route::delete('/{jenis_barang}', [JenisBarangController::class, 'destroy'])
            ->middleware('permission:jenis-barang.delete')
            ->name('jenis-barang.destroy');
        Route::get('/updates', [JenisBarangController::class, 'getUpdates'])->name('jenis-barang.updates');
    });

    // Barang Routes
    Route::prefix('barang')->middleware('permission:barang.view')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::middleware('permission:barang.create')->group(function () {
            Route::post('/create', [BarangController::class, 'create'])->name('barang.create');
        });
        Route::middleware('permission:barang.edit')->group(function () {
            Route::put('/{id}/update', [BarangController::class, 'update'])->name('barang.update');
        });
        Route::delete('/{id}/delete', [BarangController::class, 'delete'])
            ->middleware('permission:barang.delete')
            ->name('barang.delete');
        Route::get('/{id}/barcode', [BarangController::class, 'generateBarcode'])->name('barang.barcode');
        Route::get('/{id}/download-barcode', [BarangController::class, 'downloadBarcode'])->name('barang.download-barcode');
    });

    // Gudang Routes
    Route::prefix('gudang')->middleware('permission:gudang.view')->group(function () {
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::middleware('permission:gudang.create')->group(function () {
            Route::post('/create', [GudangController::class, 'create'])->name('gudang.create');
        });
        Route::middleware('permission:gudang.edit')->group(function () {
            Route::put('/{id}/update', [GudangController::class, 'update'])->name('gudang.update');
        });
        Route::delete('/{id}/delete', [GudangController::class, 'delete'])
            ->middleware('permission:gudang.delete')
            ->name('gudang.delete');
        Route::get('/{id}/barcode', [GudangController::class, 'generateBarcode'])->name('gudang.barcode');
        Route::get('/{id}/download-barcode', [GudangController::class, 'downloadBarcode'])->name('gudang.download-barcode');
    });

    // User Access Management Routes
    Route::prefix('user-access')->middleware('permission:user.view')->group(function () {
        Route::get('/', [UserAccessManagementController::class, 'index'])->name('user-access.index');
        Route::middleware('permission:user.edit')->group(function () {
            Route::post('/assign-role', [UserAccessManagementController::class, 'assignRole'])->name('user-access.assign-role');
            Route::post('/remove-role', [UserAccessManagementController::class, 'removeRole'])->name('user-access.remove-role');
            Route::post('/give-permission', [UserAccessManagementController::class, 'givePermission'])->name('user-access.give-permission');
            Route::post('/revoke-permission', [UserAccessManagementController::class, 'revokePermission'])->name('user-access.revoke-permission');
        });
        Route::get('/permissions/{userId?}', [UserAccessManagementController::class, 'getUserPermissions'])->name('user-access.permissions');
        Route::get('/routes/{userId?}', [UserAccessManagementController::class, 'getAccessibleRoutes'])->name('user-access.routes');
    });

    // Logout Route
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
});

// Fallback route
Route::fallback(function () {
    return view('errors.404');
})->name('fallback');
