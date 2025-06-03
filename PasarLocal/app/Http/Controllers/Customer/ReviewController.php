<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Pemesanan;
use App\Models\ProdukPedagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function create(Pemesanan $pemesanan, $produk)
    {
        // Log untuk debug
        \Log::info('Review Create Debug', [
            'pemesanan_id' => $pemesanan->id,
            'pemesanan_customer_id' => $pemesanan->customer_id,
            'auth_user_id' => Auth::id(),
            'pemesanan_status' => $pemesanan->status,
            'produk_id' => $produk
        ]);

        // Pastikan pemesanan milik user yang login
        if ($pemesanan->customer_id !== Auth::user()->customer->id) {
            \Log::error('Unauthorized access - Customer ID mismatch', [
                'pemesanan_customer_id' => $pemesanan->customer_id,
                'auth_user_id' => Auth::id()
            ]);
            abort(403, 'Unauthorized access');
        }

        // Pastikan status pemesanan selesai
        if (strtolower($pemesanan->status) !== 'selesai') {
            \Log::error('Unauthorized access - Order not completed', [
                'pemesanan_status' => $pemesanan->status
            ]);
            abort(403, 'Pemesanan belum selesai');
        }

        // Dapatkan produk pedagang beserta relasi pedagang dan produk
        $produkPedagang = ProdukPedagang::with(['pedagang.pasar', 'produk'])
            ->where('id_produk_pedagang', $produk)
            ->firstOrFail();


        // Pastikan produk ada di detail pemesanan
        $detail = $pemesanan->detailPemesanans()
            ->where('produk_pedagang_id', $produkPedagang->id_produk_pedagang)
            ->first();

        if (!$detail) {
            abort(404, 'Produk tidak ditemukan dalam pemesanan');
        }

        return view('customer.review.create', compact('pemesanan', 'produkPedagang', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Pastikan pemesanan terkait review milik user yang login (redundant, tapi aman)
        if ($review->pemesanan && $review->pemesanan->customer_id !== Auth::user()->customer->id) {
             abort(403, 'Unauthorized access');
        }

        // Muat relasi produk pedagang dan pemesanan
        $review->load(['produkPedagang.produk', 'produkPedagang.pedagang.pasar', 'pemesanan']);

        return view('customer.review.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

         // Pastikan pemesanan terkait review milik user yang login (redundant, tapi aman)
        if ($review->pemesanan && $review->pemesanan->customer_id !== Auth::user()->customer->id) {
             abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            // Tidak perlu validasi pemesanan_id dan produk_pedagang_id di sini
            'feedback' => 'required|string'
        ]);

        $review->update([
            'feedback' => $validated['feedback']
        ]);

        return redirect()->route('riwayat.transaksi')
            ->with('success', 'Review berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $review->delete();

        return redirect()->route('riwayat.transaksi')
            ->with('success', 'Review berhasil dihapus');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'produk_pedagang_id' => 'required|exists:produk_pedagang,id_produk_pedagang',
            'feedback' => 'required|string'
        ]);

        // Pastikan pemesanan milik user yang login
        $pemesanan = Pemesanan::findOrFail($validated['pemesanan_id']);
        if ($pemesanan->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Unauthorized access');
        }

        // Pastikan status pemesanan selesai
        if (strtolower($pemesanan->status) !== 'selesai') {
            abort(403, 'Pemesanan belum selesai');
        }

        // Pastikan produk ada di detail pemesanan
        $detail = $pemesanan->detailPemesanans()
            ->where('produk_pedagang_id', $validated['produk_pedagang_id'])
            ->first();

        if (!$detail) {
            abort(404, 'Produk tidak ditemukan dalam pemesanan');
        }

        // Simpan review
        Review::create([
            'user_id' => Auth::id(),
            'pemesanan_id' => $validated['pemesanan_id'],
            'produk_pedagang_id' => $validated['produk_pedagang_id'],
            'feedback' => $validated['feedback']
        ]);

        return redirect()->route('riwayat.transaksi')
            ->with('success', 'Review berhasil disimpan');
    }
}
