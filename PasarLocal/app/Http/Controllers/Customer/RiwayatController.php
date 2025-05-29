<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = Transaksi::with(['produkPedagang', 'user', 'pasar'])
            ->where('id_user', auth()->id())
            ->when($request->search, fn($q) =>
                $q->whereHas('produkPedagang', fn($q2) =>
                    $q2->where('nama_produk', 'like', '%' . $request->search . '%')
                )
            )
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status)
            )
            ->latest()
            ->paginate(10);

        return view('customer.riwayat-pemesanan.index', compact('transaksis'));
    }


}
