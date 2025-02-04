<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [LoginController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [LoginController::class, 'profile'])->middleware('auth:api');
});

// Gudang routes with authentication
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'gudang'
], function ($router) {
    Route::get('/', [GudangController::class, 'index']);
    Route::post('/', [GudangController::class, 'store']);
    Route::get('/{id}', [GudangController::class, 'show']);
    Route::put('/{id}', [GudangController::class, 'update']);
    Route::delete('/{id}', [GudangController::class, 'destroy']);
});

// Satuan routes with authentication
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'satuan'
], function ($router) {
    Route::get('/', [SatuanController::class, 'show']);
    Route::post('/', [SatuanController::class, 'store']);
    Route::put('/{satuan}', [SatuanController::class, 'update']);
    Route::delete('/{satuan}', [SatuanController::class, 'destroy']);
});

// Jenis Barang routes with authentication
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'jenisbarang'
], function ($router) {
    Route::get('/', [JenisBarangController::class, 'show']);
    Route::post('/', [JenisBarangController::class, 'store']);
    Route::put('/{jenisbarang}', [JenisBarangController::class, 'update']);
    Route::delete('/{jenisbarang}', [JenisBarangController::class, 'destroy']);
});
