<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;
use App\Http\Controllers\Admin\BarangController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->group(function () {
    // Auth routes - basic permissions
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('permission:auth.logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('permission:auth.refresh');
        Route::get('/me', [AuthController::class, 'me'])->middleware('permission:auth.me');
    });

    // Access control routes - admin only
    Route::prefix('access-control')->middleware(['permission:access-control.manage'])->group(function () {
        Route::get('/users', [UserAccessController::class, 'getAllUsers'])
            ->middleware('permission:access-control.users.view');


        Route::post('/give-permission', [UserAccessController::class, 'givePermission'])
            ->middleware('permission:permission.assign');
        Route::post('/revoke-permission', [UserAccessController::class, 'revokePermission'])
            ->middleware('permission:permission.revoke');

        Route::post('/assign-role', [UserAccessController::class, 'assignRole'])
            ->middleware('permission:role.assign');
        Route::post('/remove-role', [UserAccessController::class, 'removeRole'])
            ->middleware('permission:role.remove');

        Route::get('/user/{userId}/permissions', [UserAccessController::class, 'getUserPermissions'])
            ->middleware('permission:user.view');
        Route::get('/user/{userId}/accessible-routes', [UserAccessController::class, 'getAccessibleRoutes'])
            ->middleware('permission:user.view');
        Route::get('/user/{userId}/full-access-info', [UserAccessController::class, 'getFullAccessInfo'])
            ->middleware('permission:user.view');
    });

    // Resource routes
    Route::prefix('gudang')->middleware('permission:gudang.access')->group(function () {
        Route::get('/', [GudangController::class, 'index'])
            ->middleware('permission:gudang.view');
        Route::post('/', [GudangController::class, 'store'])
            ->middleware('permission:gudang.create');
        Route::get('/{id}', [GudangController::class, 'show'])
            ->middleware('permission:gudang.view');
        Route::put('/{id}', [GudangController::class, 'update'])
            ->middleware('permission:gudang.edit');
        Route::delete('/{id}', [GudangController::class, 'destroy'])
            ->middleware('permission:gudang.delete');
    });

    // Resource routes with permission middleware
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
        Route::get('/{id}/barcode', [BarangController::class, 'getBarcode']);
        Route::get('/{id}/barcode/download', [BarangController::class, 'downloadBarcode']);
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
