<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProdukPedagang;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer || !$customer->id) {
            return redirect()->back()->with('error', 'Anda belum login.');
        }

        $customerId = $customer->id;

        $carts = Cart::with([
            'pasar',
            'items.produkPedagang.produk' // Tambahkan relasi produk
        ])
            ->where('customer_id', $customerId)
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
            $customerId = $customer->id;
            if (!$customerId) {
                return redirect()->back()->with('error', 'Anda belum login.');
            }

            // Lock produk
            $produkPedagang = ProdukPedagang::where('id_produk_pedagang', $request->produk_pedagang_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($produkPedagang->stok < $request->quantity) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }

            $pedagang = $produkPedagang->pedagang;
            if (!$pedagang) {
                return redirect()->back()->with('error', 'Pedagang tidak ditemukan.');
            }

            // Gunakan user_id sebagai penanda pemilik keranjang
            $cart = Cart::firstOrCreate([
                'customer_id' => $customerId,
                'pasar_id' => $pedagang->id_pasar,
            ]);

            // Tambah atau update item di cart
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

            // Kurangi stok
            $produkPedagang->decrement('stok', $request->quantity);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
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
