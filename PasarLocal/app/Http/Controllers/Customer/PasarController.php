<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Pedagang;
use App\Models\ProdukPedagang;

class PasarController extends Controller
{
    public function show($id)
    {
        $pasar = Pasar::findOrFail($id);
        $pedagangs = Pedagang::where('id_pasar', $id)->pluck('id_pedagang');
        $produkPedagang = ProdukPedagang::with('produk', 'pedagang')
            ->whereIn('id_pedagang', $pedagangs)
            ->get();
        return view('customer.pasar-detail', compact('pasar', 'produkPedagang'));
    }
} 