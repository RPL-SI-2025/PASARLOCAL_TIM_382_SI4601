<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth');



Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

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
