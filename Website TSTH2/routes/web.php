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
Route::view('/transaksi', 'Admin.Barang.Transaksi')->name('transaksi');
Route::view('/jenisbarang', 'Admin.JenisBarang.index')->name('jenisbarang');
Route::view('/satuan', 'Admin.Satuan.index')->name('satuan');



// Logout (hanya menghapus token di frontend)
Route::post('/logout', function () {
    return redirect('/login');
})->name('logout');
