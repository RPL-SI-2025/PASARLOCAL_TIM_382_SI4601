<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($pemesanan_id, $produk_id)
    {
        $pemesanan = Pemesanan::findOrFail($pemesanan_id);
        
        // Cek apakah pesanan milik customer yang login
        if ($pemesanan->customer_id !== Auth::user()->customer->id) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Cek apakah status pesanan sudah selesai
        if ($pemesanan->status !== 'Selesai') {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan review untuk pesanan yang sudah selesai');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('customer_id', Auth::id())
            ->where('pemesanan_id', $pemesanan_id)
            ->where('produk_id', $produk_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        return view('customer.review.create', [
            'pemesanan' => $pemesanan,
            'produk_id' => $produk_id
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'produk_id' => 'required|exists:produk,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500'
        ]);

        $pemesanan = Pemesanan::findOrFail($validated['pemesanan_id']);

        // Cek apakah pesanan milik customer yang login
        if ($pemesanan->customer_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Cek apakah status pesanan sudah selesai
        if ($pemesanan->status !== 'Selesai') {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan review untuk pesanan yang sudah selesai');
        }

        $review = Review::create([
            'customer_id' => Auth::id(),
            'produk_id' => $validated['produk_id'],
            'pemesanan_id' => $validated['pemesanan_id'],
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar']
        ]);

        return redirect()->route('customer.riwayat.show', $pemesanan->id)
            ->with('success', 'Review berhasil ditambahkan');
    }
}
