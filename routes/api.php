<?php

// use App\Http\Controllers\Admin\LoginController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;

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