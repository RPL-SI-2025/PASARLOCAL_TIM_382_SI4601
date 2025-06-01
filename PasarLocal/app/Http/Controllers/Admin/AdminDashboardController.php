<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pedagang;
use App\Models\KategoriProduk as Kategori;


class AdminDashboardController extends Controller
{
   public function index()
{
    $jumlahProduk = Produk::count();
    $jumlahPedagang = Pedagang::count();
    $jumlahKategori = Kategori::count();

    return view('admin.dashboard', compact('jumlahProduk', 'jumlahPedagang', 'jumlahKategori'));
}

}
