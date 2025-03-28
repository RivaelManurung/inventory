<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;
use App\Http\Controllers\Admin\BarangController;
// use App\Http\Controllers\Master\RoleController;
// use App\Http\Controllers\Master\UserController;
// use App\Http\Controllers\Master\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    // If you need registration
    // Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes with JWT authentication
Route::middleware(['auth:api'])->group(function () {
    // Authentication related routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/permissions', [UserAccessController::class, 'getUserPermissions']);
        Route::get('/accessible-routes', [UserAccessController::class, 'getAccessibleRoutes']);
        Route::get('/full-access-info', [UserAccessController::class, 'getFullAccessInfo']);
    });
    // // Profile routes
    // Route::prefix('profile')->group(function () {
    //     Route::get('/', [UserController::class, 'profile']);
    //     Route::post('/update-password', [UserController::class, 'updatePassword']);
    //     Route::post('/update-profile', [UserController::class, 'updateProfile']);
    // });

    // // Gudang routes - protected with permission
// Gudang routes - protected with permission
Route::prefix('gudang')->middleware('permission:gudang.view')->group(function () {
    Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
    Route::post('/', [GudangController::class, 'store'])->name('gudang.store')
         ->middleware('permission:gudang.create');
    Route::get('/{id}', [GudangController::class, 'show'])->name('gudang.show');
    Route::put('/{id}', [GudangController::class, 'update'])->name('gudang.update')
         ->middleware('permission:gudang.edit');
    Route::delete('/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy')
         ->middleware('permission:gudang.delete');
});

    // Barang routes - protected with permission
    Route::prefix('barang')->middleware('permission:barang.view')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::post('/', [BarangController::class, 'store'])->middleware('permission:barang.create');
        Route::put('/{id}', [BarangController::class, 'update'])->middleware('permission:barang.edit');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->middleware('permission:barang.delete');
    });

    // Satuan routes - protected with permission
    Route::prefix('satuan')->middleware('permission:satuan.view')->group(function () {
        Route::get('/', [SatuanController::class, 'index']);
        Route::get('/{id}', [SatuanController::class, 'show']);
        Route::post('/', [SatuanController::class, 'store'])->middleware('permission:satuan.create');
        Route::put('/{id}', [SatuanController::class, 'update'])->middleware('permission:satuan.edit');
        Route::delete('/{id}', [SatuanController::class, 'destroy'])->middleware('permission:satuan.delete');
    });

    // Jenis Barang routes - protected with permission
    Route::prefix('jenis-barang')->middleware('permission:jenis-barang.view')->group(function () {
        Route::get('/', [JenisBarangController::class, 'index']);
        Route::post('/', [JenisBarangController::class, 'store'])->middleware('permission:jenis-barang.create');
        Route::put('/{id}', [JenisBarangController::class, 'update'])->middleware('permission:jenis-barang.edit');
        Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->middleware('permission:jenis-barang.delete');
    });

    // // Role management routes - protected with permission
    // Route::prefix('roles')->middleware('permission:role.view')->group(function () {
    //     Route::get('/', [RoleController::class, 'index']);
    //     Route::post('/', [RoleController::class, 'store'])->middleware('permission:role.create');
    //     Route::get('/{id}', [RoleController::class, 'show']);
    //     Route::put('/{id}', [RoleController::class, 'update'])->middleware('permission:role.edit');
    //     Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware('permission:role.delete');
        
    //     // Role permissions
    //     Route::post('/{id}/permissions', [RoleController::class, 'assignPermissions'])->middleware('permission:role.edit');
    //     Route::get('/{id}/permissions', [RoleController::class, 'getPermissions']);
    // });

    // // User management routes - protected with permission
    // Route::prefix('users')->middleware('permission:user.view')->group(function () {
    //     Route::get('/', [UserController::class, 'index']);
    //     Route::post('/', [UserController::class, 'store'])->middleware('permission:user.create');
    //     Route::get('/{id}', [UserController::class, 'show']);
    //     Route::put('/{id}', [UserController::class, 'update'])->middleware('permission:user.edit');
    //     Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('permission:user.delete');
        
    //     // User roles and permissions
    //     Route::post('/{id}/roles', [UserController::class, 'assignRoles'])->middleware('permission:user.edit');
    //     Route::get('/{id}/roles', [UserController::class, 'getRoles']);
    //     Route::post('/{id}/permissions', [UserController::class, 'assignPermissions'])->middleware('permission:user.edit');
    //     Route::get('/{id}/permissions', [UserController::class, 'getPermissions']);
    // });

    // // Permission management routes - protected with permission
    // Route::prefix('permissions')->middleware('permission:permission.view')->group(function () {
    //     Route::get('/', [PermissionController::class, 'index']);
    //     Route::post('/', [PermissionController::class, 'store'])->middleware('permission:permission.create');
    //     Route::get('/{id}', [PermissionController::class, 'show']);
    //     Route::put('/{id}', [PermissionController::class, 'update'])->middleware('permission:permission.edit');
    //     Route::delete('/{id}', [PermissionController::class, 'destroy'])->middleware('permission:permission.delete');
    // });
});