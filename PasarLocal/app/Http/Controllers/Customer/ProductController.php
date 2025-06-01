<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProdukPedagang;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProductController extends Controller
{
    public function show($produkId)
    {
        $produkPedagangs = ProdukPedagang::with(['produk', 'pedagang.pasar'])
            ->where('produk_id', $produkId)
            ->get();

        if ($produkPedagangs->isEmpty()) {
            abort(404, 'Produk tidak ditemukan di pasar mana pun.');
        }

        $produk = $produkPedagangs->first()->produk;
            
        return view('customer.product-detail', compact('produkPedagangs', 'produk'));
    }
} 