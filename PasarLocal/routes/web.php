<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth');



Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');