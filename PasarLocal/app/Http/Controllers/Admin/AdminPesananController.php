<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Collection;

class AdminPesananController extends Controller
{
    // Daftar status yang valid (pastikan sama dengan database / enum)
    private $statuses = ['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Batal'];

    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Pemesanan::with(['customer', 'detailPemesanans.produkPedagang.produk', 'ongkir']);

        if ($search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('nama_customer', 'like', '%' . $search . '%');
            });
        }

        $orders = $query->latest()->get();

        // Initialize empty collection for each status and fill with orders
        $groupedOrders = collect();
        foreach ($this->statuses as $status) {
            $groupedOrders[$status] = $orders->filter(function($order) use ($status) {
                return strtolower($order->status) === strtolower($status);
            })->values();
        }

        return view('admin.manajemen-pesanan.index', [
            'groupedOrders' => $groupedOrders,
            'search' => $search,
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Pemesanan::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function show($id)
    {
        // Ambil data pemesanan beserta relasi yang dibutuhkan
        $order = Pemesanan::with([
            'customer',
            'detailPemesanans.produkPedagang.produk',
            'detailPemesanans.produkPedagang.pedagang.pasar',
            'ongkir',
        ])->findOrFail($id);
        return view('admin.manajemen-pesanan.index-detail', [
            'order' => $order,
            'statuses' => $this->statuses,
        ]);
    }
}
