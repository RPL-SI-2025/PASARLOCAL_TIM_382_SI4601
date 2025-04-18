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

#kategori-produk
Route::get('/admin/kategori-produk', [KategoriProdukController::class, 'index'])->name('admin.kategori-produk.index');
Route::get('/admin/kategori-produk/create', [KategoriProdukController::class, 'create'])->name('admin.kategori-produk.create');
Route::post('/admin/kategori-produk', [KategoriProdukController::class, 'store'])->name('admin.kategori-produk.store');
Route::get('/admin/kategori-produk/{id}/edit', [KategoriProdukController::class, 'edit'])->name('admin.kategori-produk.edit');
Route::put('/admin/kategori-produk/{id}', [KategoriProdukController::class, 'update'])->name('admin.kategori-produk.update');
Route::delete('/admin/kategori-produk/{id}', [KategoriProdukController::class, 'destroy'])->name('admin.kategori-produk.destroy');
