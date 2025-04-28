<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProdukPedagangController;
use App\Http\Controllers\PedagangController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Produk Pedagang Routes
Route::prefix('pedagang')->name('pedagang.')->group(function () {
    Route::get('manajemen-produk', [ProdukPedagangController::class, 'index'])->name('manajemen-produk');
    Route::get('tambah-produk', [ProdukPedagangController::class, 'create'])->name('tambah-produk');
    Route::post('store-produk', [ProdukPedagangController::class, 'store'])->name('store-produk');
    Route::get('edit-produk/{id}', [ProdukPedagangController::class, 'edit'])->name('edit-produk');
    Route::put('update-produk/{id}', [ProdukPedagangController::class, 'update'])->name('update-produk');
    Route::delete('delete-produk/{id}', [ProdukPedagangController::class, 'destroy'])->name('delete-produk');
    Route::get('detail-produk/{id}', [ProdukPedagangController::class, 'show'])->name('detail-produk');
});

// Admin Routes
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

# Verifikasi routes
Route::get('/verify-code', [AuthController::class, 'showVerifyCodeForm'])->name('auth.show-verify-code');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('auth.verify-code');
Route::get('/resend-code', [AuthController::class, 'resendCode'])->name('auth.resend-code');

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('search', [ProductController::class, 'search'])->name('search');
    Route::get('filter', [ProductController::class, 'filter'])->name('filter');
    Route::get('product/{name}', [ProductController::class, 'show'])->name('product.show');
});
