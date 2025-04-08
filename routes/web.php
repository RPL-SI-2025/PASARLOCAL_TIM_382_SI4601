<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ongkir', [ShippingController::class, 'showForm']);
Route::post('/ongkir', [ShippingController::class, 'calculate'])->name('ongkir.hitung');
