<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Pedagang;
use App\Models\ProdukPedagang;

class PasarController extends Controller
{
    public function show($id, Request $request)
    {
        $pasar = Pasar::findOrFail($id);
        $pedagangs = Pedagang::where('id_pasar', $id)->pluck('id_pedagang');
        $q = $request->q;
        $produkPedagang = ProdukPedagang::with('produk', 'pedagang')
            ->whereIn('id_pedagang', $pedagangs)
            ->when($q, function($query) use ($q) {
                $query->whereHas('produk', function($q2) use ($q) {
                    $q2->where('nama_produk', 'like', "%$q%" );
                });
            })
            ->get();
        return view('customer.pasar-detail', compact('pasar', 'produkPedagang'));
    }
}