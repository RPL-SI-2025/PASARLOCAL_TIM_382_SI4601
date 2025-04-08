<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/kategori-produk', [KategoriProdukController::class, 'index'])->name('kategori-produk.index');
Route::get('/kategori-produk/create', [KategoriProdukController::class, 'create'])->name('kategori-produk.create');
Route::post('/kategori-produk', [KategoriProdukController::class, 'store'])->name('kategori-produk.store');
Route::get('/kategori-produk/{id}/edit', [KategoriProdukController::class, 'edit'])->name('kategori-produk.edit');
Route::put('/kategori-produk/{id}', [KategoriProdukController::class, 'update'])->name('kategori-produk.update');
Route::delete('/kategori-produk/{id}', [KategoriProdukController::class, 'destroy'])->name('kategori-produk.destroy');
