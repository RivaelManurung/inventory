<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PermissionController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Prefix 'user' hanya bisa diakses oleh superadmin
    Route::prefix('user')->middleware(['auth:api', 'role:superadmin'])->group(function () {
        Route::get('/permissions', [UserAccessController::class, 'getUserPermissions']);
        Route::get('/accessible-routes', [UserAccessController::class, 'getAccessibleRoutes']);
        Route::get('/full-access-info', [UserAccessController::class, 'getFullAccessInfo']);
        Route::post('/give-permission', [UserAccessController::class, 'givePermission']);
        Route::post('/revoke-permission', [UserAccessController::class, 'revokePermission']);
        Route::post('/assign-role', [UserAccessController::class, 'assignRole']);
        Route::post('/remove-role', [UserAccessController::class, 'removeRole']);
    });

    Route::middleware('permission:gudang.view')->prefix('gudang')->group(function () {
        Route::get('/', [GudangController::class, 'index']);
        Route::post('/', [GudangController::class, 'store'])->middleware('permission:gudang.create');
        Route::get('/{id}', [GudangController::class, 'show']);
        Route::put('/{id}', [GudangController::class, 'update'])->middleware('permission:gudang.edit');
        Route::delete('/{id}', [GudangController::class, 'destroy'])->middleware('permission:gudang.delete');
    });

    Route::middleware('permission:barang.view')->prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/', [BarangController::class, 'store'])->middleware('permission:barang.create');
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::put('/{id}', [BarangController::class, 'update'])->middleware('permission:barang.edit');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->middleware('permission:barang.delete');

        // Tambahkan route baru khusus untuk barcode
        Route::get('/{id}/barcode', [BarangController::class, 'getBarcode'])->middleware('permission:barang.view');
        Route::get('/{id}/barcode/download', [BarangController::class, 'downloadBarcode'])->middleware('permission:barang.view');
    });

    Route::middleware('permission:satuan.view')->prefix('satuan')->group(function () {
        Route::get('/', [SatuanController::class, 'index']);
        Route::post('/', [SatuanController::class, 'store'])->middleware('permission:satuan.create');
        Route::get('/{id}', [SatuanController::class, 'show']);
        Route::put('/{id}', [SatuanController::class, 'update'])->middleware('permission:satuan.edit');
        Route::delete('/{id}', [SatuanController::class, 'destroy'])->middleware('permission:satuan.delete');
    });

    Route::middleware('permission:jenis-barang.view')->prefix('jenis-barang')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index']);
        Route::post('/', [JenisBarangController::class, 'store'])->middleware('permission:jenis-barang.create');
        Route::put('/{id}', [JenisBarangController::class, 'update'])->middleware('permission:jenis-barang.edit');
        Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->middleware('permission:jenis-barang.delete');
    });
});
