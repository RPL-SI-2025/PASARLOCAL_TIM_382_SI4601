<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukPedagang;
use App\Models\Pasar;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type'); // 'product' or 'market'

        $results = [];

        if ($type === 'product' || !$type) {
            // Search in ProdukPedagang (join with Produk for name)
            $productResults = ProdukPedagang::with(['produk', 'pedagang.pasar'])
                ->whereHas('produk', function ($q) use ($query) {
                    $q->where('nama_produk', 'like', '%' . $query . '%');
                })
                ->limit(10)
                ->get();

            $results['products'] = $productResults->map(function ($item) {
                return [
                    'id' => $item->produk_id,
                    'name' => $item->produk->nama_produk,
                    'image' => asset('uploads_produk/' . $item->produk->gambar),
                    'url' => route('customer.product.show', $item->produk_id),
                    'market_name' => $item->pedagang->pasar->nama_pasar ?? 'Pasar tidak diketahui'
                ];
            });
        }

        if ($type === 'market' || !$type) {
            // Search in Pasar
            $marketResults = Pasar::where('nama_pasar', 'like', '%' . $query . '%')
                ->limit(10)
                ->get();

            $results['markets'] = $marketResults->map(function ($item) {
                return [
                    'id' => $item->id_pasar,
                    'name' => $item->nama_pasar,
                    'image' => asset('uploads_pasar/' . $item->gambar),
                    'url' => route('customer.pasar.show', $item->id_pasar)
                ];
            });
        }

        return response()->json($results);
    }
}
