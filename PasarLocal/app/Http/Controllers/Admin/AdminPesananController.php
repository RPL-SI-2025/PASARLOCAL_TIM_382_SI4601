<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminPesananController extends Controller
{
  public function index(Request $request)
{
    $data = collect([
        (object)[
            'id' => 1,
            'customer' => (object)['nama_customer' => 'Mariska Harindra'],
            'total' => 120000,
            'status_pesanan' => 'Belum Diproses',
            'pembayaran' => (object)['status_pembayaran' => 'Belum Lunas'],
        ],
        (object)[
            'id' => 2,
            'customer' => (object)['nama_customer' => 'Alan Darendra'],
            'total' => 200000,
            'status_pesanan' => 'Dikirim',
            'pembayaran' => (object)['status_pembayaran' => 'Lunas'],
        ],
        (object)[
            'id' => 3,
            'customer' => (object)['nama_customer' => 'Dewi Sartika'],
            'total' => 90000,
            'status_pesanan' => 'Diproses',
            'pembayaran' => (object)['status_pembayaran' => 'Lunas'],
        ],
    ]);

    $search = $request->query('search');

    if ($search) {
        $data = $data->filter(function ($order) use ($search) {
            return stripos($order->customer->nama_customer, $search) !== false;
        })->values();
    }

    $groupedOrders = $data->groupBy('status_pesanan');

    return view('admin.manajemen-pesanan.index', compact('groupedOrders', 'search'));
}

public function update(Request $request, $id)
{
    // Dummy update simulation (tidak simpan ke database)
    $status = $request->input('status_pesanan');

    // Redirect balik ke index dengan status sukses
    return redirect()->route('admin.manajemen-pesanan.index')
        ->with('success', "Status pesanan #$id berhasil diperbarui menjadi '$status'.");
}

}