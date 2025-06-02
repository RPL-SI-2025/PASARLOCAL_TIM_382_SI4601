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
                $produk = $item->produk;
                $pedagang = $item->pedagang;
                $pasar = $pedagang && $pedagang->pasar ? $pedagang->pasar : null;
                return [
                    'id_produk_pedagang' => $item->id_produk_pedagang, // gunakan id_produk_pedagang sebagai id utama
                    'name' => $produk ? $produk->nama_produk : '-',
                    'image' => $produk && $produk->gambar ? asset('uploads_produk/' . $produk->gambar) : asset('default.jpg'),
                    'url' => route('customer.product.show', $item->id_produk_pedagang), // gunakan id_produk_pedagang untuk url detail
                    'market_name' => $pasar ? $pasar->nama_pasar : 'Pasar tidak diketahui',
                    'pedagang' => $pedagang ? $pedagang->nama_pemilik : '-',
                    'harga' => $item->harga ?? 0,
                    'stok' => $item->stok ?? 0,
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
