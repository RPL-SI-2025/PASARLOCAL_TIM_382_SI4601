<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ProdukPedagang;
use Illuminate\Support\Facades\Auth;

class ReviewProdukController extends Controller
{
    public function index()
    {
        // Get all products owned by the current merchant
        $merchantId = Auth::id();
        $products = ProdukPedagang::where('id_pedagang', $merchantId)->get();
        
        // Get all reviews for these products
        $reviews = Review::whereIn('produk_id', $products->pluck('id_produkpedagang'))
            ->with(['user', 'produk'])
            ->latest()
            ->paginate(10);

        return view('pedagang.review.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::with(['user', 'produk'])->findOrFail($id);
        
        // Verify that the review belongs to a product owned by the current merchant
        if ($review->produk->id_pedagang !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pedagang.review.show', compact('review'));
    }
} 