<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;

class AdminPesananController extends Controller
{
    // Daftar status yang valid (pastikan sama dengan database / enum)
    private $statuses = ['belum proses', 'diproses', 'dikirim', 'selesai', 'batal'];

    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Pemesanan::with(['customer', 'detailPemesanans.produk', 'ongkir']);

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
        $request->validate([
            'status_pesanan' => 'required|string|in:' . implode(',', $this->statuses),
        ]);

        $pemesanan = Pemesanan::findOrFail($id);

        $pemesanan->status = $request->status_pesanan;
        $pemesanan->save();

        return redirect()->route('admin.manajemen-pesanan.index')
            ->with('success', "Status pesanan #$id berhasil diperbarui menjadi '{$pemesanan->status}'.");
    }

    public function show($id)
    {
        // Ambil data pemesanan beserta relasi yang dibutuhkan
        $pemesanan = Pemesanan::with(['detailPemesanans.produk', 'customer', 'ongkir'])
                    ->findOrFail($id);

        return view('admin.manajemen-pesanan.show', compact('pemesanan'));
    }

}
