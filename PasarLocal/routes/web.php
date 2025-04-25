<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasarController;
use App\Http\Controllers\PedagangController;

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

#produk-admin
Route::get('/admin/manajemen-produk', [ManajemenProdukController::class, 'index'])->name('admin.manajemen-produk.index');
Route::get('/admin/manajemen-produk/create', [ManajemenProdukController::class, 'create'])->name('admin.manajemen-produk.create');
Route::post('/admin/manajemen-produk', [ManajemenProdukController::class, 'store'])->name('admin.manajemen-produk.store');
Route::get('/admin/manajemen-produk/{id}/edit', [ManajemenProdukController::class, 'edit'])->name('admin.manajemen-produk.edit');
Route::put('/admin/manajemen-produk/{id}', [ManajemenProdukController::class, 'update'])->name('admin.manajemen-produk.update');
Route::delete('/admin/manajemen-produk/{id}', [ManajemenProdukController::class, 'destroy'])->name('admin.manajemen-produk.destroy');
Route::get('/admin/manajemen-produk/{id}', [ManajemenProdukController::class, 'show'])->name('admin.manajemen-produk.show');

#pasar
Route::get('/admin/manajemen-pasar', [PasarController::class, 'index'])->name('admin.manajemen-pasar.index');
Route::get('/admin/manajemen-pasar/create', [PasarController::class, 'create'])->name('admin.manajemen-pasar.create');
Route::post('/admin/manajemen-pasar', [PasarController::class, 'store'])->name('admin.manajemen-pasar.store');
Route::get('/admin/manajemen-pasar/{id}/edit', [PasarController::class, 'edit'])->name('admin.manajemen-pasar.edit');
Route::put('/admin/manajemen-pasar/{id}', [PasarController::class, 'update'])->name('admin.manajemen-pasar.update');
Route::delete('/admin/manajemen-pasar/{id}', [PasarController::class, 'destroy'])->name('admin.manajemen-pasar.destroy');

#pedagang
Route::get('/admin/manajemen-pedagang', [PedagangController::class, 'index'])->name('admin.manajemen-pedagang.index');
Route::get('/admin/manajemen-pedagang/create', [PedagangController::class, 'create'])->name('admin.manajemen-pedagang.create');
Route::post('/admin/manajemen-pedagang', [PedagangController::class, 'store'])->name('admin.manajemen-pedagang.store');
Route::get('/admin/manajemen-pedagang/{id}/edit', [PedagangController::class, 'edit'])->name('admin.manajemen-pedagang.edit');
Route::put('/admin/manajemen-pedagang/{id}', [PedagangController::class, 'update'])->name('admin.manajemen-pedagang.update');
Route::delete('/admin/manajemen-pedagang/{id}', [PedagangController::class, 'destroy'])->name('admin.manajemen-pedagang.destroy');
