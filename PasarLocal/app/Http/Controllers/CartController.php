<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProdukPedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        if (!$customer) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
        }

        // Ambil data langsung dari database tanpa cache
        $carts = Cart::with(['pasar', 'items.produkPedagang' => function ($query) {
            $query->select('*')->withoutGlobalScopes();
        }])
            ->where('customer_id', $customer->id)
            ->get()
            ->groupBy('pasar_id');

        return view('cart.index', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'produk_pedagang_id' => 'required|exists:produk_pedagang,id_produk_pedagang',
                'quantity' => 'required|integer|min:1',
            ]);

            $customer = Auth::user()->customer;
            if (!$customer) {
                return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
            }

            // Lock the row for update to prevent race conditions
            $produkPedagang = ProdukPedagang::where('id_produk_pedagang', $request->produk_pedagang_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($produkPedagang->stok < $request->quantity) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }

            $pedagang = $produkPedagang->pedagang;
            if (!$pedagang) {
                return redirect()->back()->with('error', 'Pedagang untuk produk ini tidak ditemukan.');
            }

            // Get or create cart
            $cart = Cart::firstOrCreate([
                'customer_id' => $customer->id,
                'pasar_id' => $pedagang->id_pasar,
            ]);

            // Update or create cart item
            $cartItem = $cart->items()
                ->where('produk_pedagang_id', $request->produk_pedagang_id)
                ->first();

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $request->quantity,
                ]);
            } else {
                $cart->items()->create([
                    'produk_pedagang_id' => $request->produk_pedagang_id,
                    'quantity' => $request->quantity,
                    'price' => $produkPedagang->harga,
                ]);
            }

            // Update stock
            $produkPedagang->decrement('stok', $request->quantity);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
        });
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function removeItem(CartItem $cartItem)
    {
        $cartItem->delete();

        // If cart is empty, delete it
        if ($cartItem->cart->items()->count() === 0) {
            $cartItem->cart->delete();
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}