<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pemesanan;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $customer = Auth::user()->customer;
        if (!$customer) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
        }

        $pemesanans = Pemesanan::with(['detailPemesanans.produkPedagang.produk', 'detailPemesanans.produkPedagang.pedagang.pasar'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);
        return view('customer.riwayat-pemesanan.index', compact('pemesanans'));
    }


}
