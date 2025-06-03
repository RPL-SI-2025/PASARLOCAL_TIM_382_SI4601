<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedagang;
use App\Models\Review;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\DB;

class PedagangReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pastikan user adalah pedagang
        if (!$user || $user->role !== 'pedagang') {
            abort(403, 'Unauthorized access');
        }

        // Dapatkan model Pedagang yang terkait dengan user
        $pedagang = Pedagang::where('email', $user->email)->first();

        if (!$pedagang) {
            // Handle case where user is marked as pedagang but no related Pedagang model exists
            return redirect()->route('login')->with('error', 'Data pedagang tidak ditemukan.');
        }

        // Ambil semua review yang terkait dengan produk milik pedagang ini
        // Eager load produkPedagang, produk, user, dan pemesanan beserta detailPemesanans
        $query = Review::whereHas('produkPedagang', function ($query) use ($pedagang) {
            $query->where('id_pedagang', $pedagang->id_pedagang);
        })
        ->with(['produkPedagang.produk.kategori', 'user', 'pemesanan.detailPemesanans']); // Eager load kategori

        // Add search filter by product name (outside card)
        if ($request->filled('product_search')) {
            $search = $request->input('product_search');
            $query->whereHas('produkPedagang.produk', function ($productQuery) use ($search) {
                $productQuery->where('nama_produk', 'like', '%' . $search . '%');
            });
        }

        // Add filter by product category (outside card)
        if ($request->filled('category')) {
            $categoryId = $request->input('category');
             $query->whereHas('produkPedagang.produk', function ($productQuery) use ($categoryId) {
                $productQuery->where('id_kategori', $categoryId);
            });
        }

        // Note: Search filter by reviewer name (inside card) will be handled client-side in the view for simplicity

        $reviews = $query->latest()->get();

        // Group reviews by product_pedagang_id
        $reviewsByProduct = $reviews->groupBy('produk_pedagang_id');

        // Get all product categories for the filter dropdown
        $kategoris = KategoriProduk::all();

        return view('pedagang.reviews.index', compact('reviewsByProduct', 'request', 'kategoris'));
    }
}
