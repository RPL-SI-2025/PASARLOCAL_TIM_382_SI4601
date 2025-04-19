<?php
use App\Http\Controllers\OngkirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Halo, ini root!';
});

Route::get('/cek-ongkir', [OngkirController::class, 'index'])->name('cek-ongkir');
Route::post('/cek-ongkir', [OngkirController::class, 'cekHarga'])->name('cek-ongkir.submit');

