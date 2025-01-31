<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [LoginController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [LoginController::class, 'me'])->middleware('auth:api')->name('me');
});
