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
    public function index(Request $request)
    {
        $customer = Auth::user()->customer;
        if (!$customer) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
        }

        // Fetch carts grouped by market
        $carts = Cart::with(['pasar', 'items.produkPedagang.produk', 'items.produkPedagang.pedagang'])
            ->where('customer_id', $customer->id)
            ->get()
            ->groupBy('pasar_id');

        // Get selected item IDs from request across all markets
        $selectedItemIds = $request->input('selected_items', []);

        // Calculate the grand total for all selected items
        $grandTotal = 0;
        foreach ($carts as $marketCarts) {
            foreach ($marketCarts->first()->items as $item) {
                if (in_array($item->id, $selectedItemIds)) {
                    $grandTotal += $item->quantity * $item->price;
                }
            }
        }

        return view('customer.cart.index', compact('carts', 'grandTotal', 'selectedItemIds'));
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

            // Lock the product for stock checking
            $produkPedagang = ProdukPedagang::where('id_produk_pedagang', $request->produk_pedagang_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Check stock availability
            if ($produkPedagang->stok < $request->quantity) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }

            $pedagang = $produkPedagang->pedagang;
            if (!$pedagang) {
                return redirect()->back()->with('error', 'Pedagang untuk produk ini tidak ditemukan.');
            }

            // Get or create cart for this market
            $cart = Cart::firstOrCreate([
                'customer_id' => $customer->id,
                'pasar_id' => $pedagang->id_pasar,
            ]);

            // Check if item already exists in cart
            $cartItem = $cart->items()
                ->where('produk_pedagang_id', $request->produk_pedagang_id)
                ->first();

            // Update quantity if exists, create new if not
            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                
                // Check if new total quantity exceeds available stock
                if ($newQuantity > $produkPedagang->stok) {
                    return redirect()->back()->with('error', 'Total kuantitas melebihi stok yang tersedia.');
                }
                
                $cartItem->update([
                    'quantity' => $newQuantity
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

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        });
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        return DB::transaction(function () use ($request, $cartItem) {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            // Lock product for stock check
            $produkPedagang = ProdukPedagang::where('id_produk_pedagang', $cartItem->produk_pedagang_id)
                ->lockForUpdate()
                ->firstOrFail();

            $quantityDiff = $request->quantity - $cartItem->quantity;

            // Check if new quantity is valid
            if ($quantityDiff > 0 && $produkPedagang->stok < $quantityDiff) {
                $productName = $produkPedagang->produk->nama_produk ?? 'Produk';
                $pasarName = $produkPedagang->pedagang->pasar->nama_pasar ?? 'Pasar';
                $availableStock = $produkPedagang->stok + $cartItem->quantity;
                return redirect()->back()->with('error', $productName . ' dari ' . $pasarName . ' melebihi stok yang tersedia (' . $availableStock . ').');
            }

            // Update cart item quantity
            $cartItem->update([
                'quantity' => $request->quantity
            ]);

            // Update product stock
            $produkPedagang->increment('stok', -$quantityDiff);

            return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui.');
        });
    }

    public function removeItem(CartItem $cartItem)
    {
        return DB::transaction(function () use ($cartItem) {
            // Return stock
            $produkPedagang = ProdukPedagang::findOrFail($cartItem->produk_pedagang_id);
            $produkPedagang->increment('stok', $cartItem->quantity);

            // Delete cart item
            $cartItem->delete();

            // Delete cart if empty
            $cart = $cartItem->cart;
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }

            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        });
    }

    public function showCheckout(Request $request)
    {
        $customer = Auth::user()->customer;
        if (!$customer) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
        }

        // Ambil selected_items dari request
        $selectedItemIds = $request->input('selected_items', []);
        if (empty($selectedItemIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk yang ingin dibeli terlebih dahulu.');
        }

        // Ambil cart items beserta relasi produk, pedagang, pasar
        $cartItems = CartItem::with(['produkPedagang.produk', 'produkPedagang.pedagang.pasar', 'cart'])
            ->whereIn('id', $selectedItemIds)
            ->get();

        // Kelompokkan berdasarkan pasar
        $groupedByPasar = $cartItems->groupBy(function($item) {
            return $item->produkPedagang->pedagang->pasar->id_pasar;
        });

        // Ambil data pasar (asumsi satu pasar per checkout, bisa diubah jika multi-pasar)
        $pasar = null;
        if ($cartItems->count() > 0) {
            $pasar = $cartItems->first()->produkPedagang->pedagang->pasar;
        }

        // Hitung total harga
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        // List kecamatan
        $kecamatanList = \App\Constants\Kecamatan::getAll();

        // Cari ongkir default (berdasarkan pasar & kecamatan customer)
        $ongkir = null;
        if ($pasar && $customer->kecamatan) {
            $ongkir = \App\Models\ongkir::where('id_pasar', $pasar->id_pasar)
                ->where('kecamatan_tujuan', $customer->kecamatan)
                ->first();
        }

        return view('customer.checkout', compact('customer', 'cartItems', 'pasar', 'total', 'kecamatanList', 'ongkir'));
    }

    public function ajaxCekOngkir(Request $request)
    {
        $id_pasar = $request->input('id_pasar');
        $kecamatan = $request->input('kecamatan');
        $ongkir = null;
        if ($id_pasar && $kecamatan) {
            $ongkir = \App\Models\ongkir::where('id_pasar', $id_pasar)
                ->where('kecamatan_tujuan', $kecamatan)
                ->first();
        }
        if ($ongkir) {
            return response()->json(['ongkir' => $ongkir->ongkir]);
        } else {
            return response()->json(['ongkir' => null]);
        }
    }
}