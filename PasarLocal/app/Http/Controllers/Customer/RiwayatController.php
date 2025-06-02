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

        $status = $request->input('status'); // Get status from request

        $pemesanans = Pemesanan::with(['detailPemesanans.produkPedagang.produk', 'detailPemesanans.produkPedagang.pedagang.pasar', 'reviews'])
            ->where('customer_id', $customer->id);

        // Add filter by status if status is provided in the request
        if ($status) {
            $pemesanans->where('status', $status);
        }

        $pemesanans = $pemesanans->latest()
            ->paginate(10);

        return view('customer.riwayat-pemesanan.index', compact('pemesanans', 'status')); // Pass status to the view
    }

    public function show(Pemesanan $pemesanan)
    {
        // You can add checks here if needed, e.g., if the order belongs to the logged-in user
        // For now, we assume route model binding and middleware handle most of it.
        return view('customer.riwayat-pemesanan.show', compact('pemesanan'));
    }
}
