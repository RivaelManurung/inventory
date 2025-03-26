<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman login
Route::view('/login', 'Admin.auth.login')->name('login');

// Halaman dashboard (tanpa middleware auth)
Route::view('/dashboard', 'Admin.Dashboard.dashboard')->name('dashboard');

// Logout (hanya menghapus token di frontend)
Route::post('/logout', function () {
    return redirect('/login');
})->name('logout');
