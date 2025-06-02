<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;

class AdminPesananController extends Controller
{
    // Daftar status yang valid (pastikan sama dengan database / enum)
    private $statuses = ['belum proses', 'pending', 'dikirim', 'selesai', 'batal'];

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

        // Group berdasarkan status
        $groupedOrders = $orders->groupBy('status');
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
        $order = Pemesanan::with(['customer', 'detailPemesanans.produkPedagang', 'ongkir'])
                    ->findOrFail($id);

        return view('admin.manajemen-pesanan.index-detail', compact('order'));
    }

}
