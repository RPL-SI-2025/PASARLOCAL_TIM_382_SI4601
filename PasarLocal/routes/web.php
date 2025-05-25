<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasarController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ProdukPedagangController;
use App\Http\Controllers\Customer\IndexController;
use App\Http\Controllers\Customer\RiwayatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\Customer\PasarController as CustomerPasarController;
use App\Http\Controllers\CartController;


# Auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::match(['post', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');

# Semua route admin dikelompokkan dan dibatasi role admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    # Ongkir
    Route::get('/ongkir', [OngkirController::class, 'index'])->name('admin.ongkir.index');
    Route::get('/tambah-ongkir', [OngkirController::class, 'create'])->name('admin.ongkir.create');
    Route::get('/detail-ongkir/{id}', [OngkirController::class, 'detail'])->name('admin.ongkir.detail');
    Route::post('/store', [OngkirController::class, 'store'])->name('admin.ongkir.store');
    Route::get('/ongkir/{id}/edit', [OngkirController::class, 'edit'])->name('admin.ongkir.edit');
    Route::put('/ongkir/{ongkir}', [OngkirController::class, 'update'])->name('admin.ongkir.update');
    Route::delete('/ongkir/{ongkir}', [OngkirController::class, 'destroy'])->name('admin.ongkir.destroy');

    # Kategori Produk
    Route::get('/kategori-produk', [KategoriProdukController::class, 'index'])->name('admin.kategori-produk.index');
    Route::get('/kategori-produk/create', [KategoriProdukController::class, 'create'])->name('admin.kategori-produk.create');
    Route::post('/kategori-produk', [KategoriProdukController::class, 'store'])->name('admin.kategori-produk.store');
    Route::get('/kategori-produk/{id}/edit', [KategoriProdukController::class, 'edit'])->name('admin.kategori-produk.edit');
    Route::put('/kategori-produk/{id}', [KategoriProdukController::class, 'update'])->name('admin.kategori-produk.update');
    Route::delete('/kategori-produk/{id}', [KategoriProdukController::class, 'destroy'])->name('admin.kategori-produk.destroy');

    # Manajemen Produk
    Route::get('/manajemen-produk', [ManajemenProdukController::class, 'index'])->name('admin.manajemen-produk.index');
    Route::get('/manajemen-produk/create', [ManajemenProdukController::class, 'create'])->name('admin.manajemen-produk.create');
    Route::post('/manajemen-produk', [ManajemenProdukController::class, 'store'])->name('admin.manajemen-produk.store');
    Route::get('/manajemen-produk/{id}/edit', [ManajemenProdukController::class, 'edit'])->name('admin.manajemen-produk.edit');
    Route::put('/manajemen-produk/{id}', [ManajemenProdukController::class, 'update'])->name('admin.manajemen-produk.update');
    Route::delete('/manajemen-produk/{id}', [ManajemenProdukController::class, 'destroy'])->name('admin.manajemen-produk.destroy');
    Route::get('/manajemen-produk/{id}', [ManajemenProdukController::class, 'show'])->name('admin.manajemen-produk.show');

    # Manajemen Pasar
    Route::get('/manajemen-pasar', [PasarController::class, 'index'])->name('admin.manajemen-pasar.index');
    Route::get('/manajemen-pasar/create', [PasarController::class, 'create'])->name('admin.manajemen-pasar.create');
    Route::post('/manajemen-pasar', [PasarController::class, 'store'])->name('admin.manajemen-pasar.store');
    Route::get('/manajemen-pasar/{id}/edit', [PasarController::class, 'edit'])->name('admin.manajemen-pasar.edit');
    Route::put('/manajemen-pasar/{id}', [PasarController::class, 'update'])->name('admin.manajemen-pasar.update');
    Route::delete('/manajemen-pasar/{id}', [PasarController::class, 'destroy'])->name('admin.manajemen-pasar.destroy');

    # Manajemen Pedagang
    Route::get('/manajemen-pedagang', [PedagangController::class, 'index'])->name('admin.manajemen-pedagang.index');
    Route::get('/manajemen-pedagang/create', [PedagangController::class, 'create'])->name('admin.manajemen-pedagang.create');
    Route::post('/manajemen-pedagang', [PedagangController::class, 'store'])->name('admin.manajemen-pedagang.store');
    Route::get('/manajemen-pedagang/{id}/edit', [PedagangController::class, 'edit'])->name('admin.manajemen-pedagang.edit');
    Route::put('/manajemen-pedagang/{id}', [PedagangController::class, 'update'])->name('admin.manajemen-pedagang.update');
    Route::delete('/manajemen-pedagang/{id}', [PedagangController::class, 'destroy'])->name('admin.manajemen-pedagang.destroy');

    # Diskon
    Route::resource('diskons', DiskonController::class);
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    # Dashboard
    Route::get('/home', [IndexController::class, 'index'])->name('customer.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::match(['post', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pasar/{id}', [CustomerPasarController::class, 'show'])->name('customer.pasar.show');
    
    # Riwayat Pemesanan
    Route::get('/history', [RiwayatController::class, 'index'])->name('customer.history');

    # Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('/cart/{cartItem}', [CartController::class, 'removeItem'])->name('cart.remove-item');
});

Route::middleware(['auth', 'role:pedagang'])->group(function () {
    # Edit Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::match(['post', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');

    # Manajemen Produk
    Route::get('/pedagang/manajemen_produk', [ProdukPedagangController::class, 'index'])->name('pedagang.manajemen_produk.index');
    Route::get('/pedagang/manajemen_produk/create', [ProdukPedagangController::class, 'create'])->name('pedagang.manajemen_produk.create');
    Route::post('/pedagang/manajemen_produk', [ProdukPedagangController::class, 'store'])->name('pedagang.manajemen_produk.store');
    Route::get('/pedagang/manajemen_produk/{id}/edit', [ProdukPedagangController::class, 'edit'])->name('pedagang.manajemen_produk.edit');
    Route::put('/pedagang/manajemen_produk/{id}', [ProdukPedagangController::class, 'update'])->name('pedagang.manajemen_produk.update');
    Route::delete('/pedagang/manajemen_produk/{id}', [ProdukPedagangController::class, 'destroy'])->name('pedagang.manajemen_produk.destroy');
    Route::get('/pedagang/manajemen_produk/{id}', [ProdukPedagangController::class, 'show'])->name('pedagang.manajemen_produk.show');
});

Route::get('/produk/{id}', [App\Http\Controllers\ProdukPedagangController::class, 'detail'])->name('produk.detail');

