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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori-produk', KategoriProdukController::class);
    Route::resource('manajemen-produk', ManajemenProdukController::class);
});

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('search', [ProductController::class, 'search'])->name('search');
    Route::get('filter', [ProductController::class, 'filter'])->name('filter');
    Route::get('product/{name}', [ProductController::class, 'show'])->name('product.show');
});
