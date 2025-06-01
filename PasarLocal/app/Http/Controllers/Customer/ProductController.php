<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProdukPedagang;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $produkPedagang = ProdukPedagang::with(['produk', 'pedagang.pasar'])
            ->findOrFail($id);
            
        return view('customer.product-detail', compact('produkPedagang'));
    }
} 