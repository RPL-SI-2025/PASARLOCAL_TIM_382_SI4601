<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProdukPedagang;
use App\Models\Order;
use App\Models\Diskon;
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

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $productName . ' dari ' . $pasarName . ' melebihi stok yang tersedia (' . $availableStock . ').'
                    ]);
                }

                return redirect()->back()->with('error', $productName . ' dari ' . $pasarName . ' melebihi stok yang tersedia (' . $availableStock . ').');
            }

            // Update cart item quantity
            $cartItem->update([
                'quantity' => $request->quantity
            ]);

            // Update product stock
            $produkPedagang->increment('stok', -$quantityDiff);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah produk berhasil diperbarui.',
                    'subtotal' => $cartItem->quantity * $cartItem->price
                ]);
            }

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

        // Ambil diskon yang tersedia
        $availableDiskons = \App\Models\Diskon::where('aktif', true)
            ->where(function($query) use ($total) {
                $query->whereNull('min_pembelian')
                    ->orWhere('min_pembelian', '<=', $total);
            })
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->get();

        return view('customer.checkout', compact('customer', 'cartItems', 'pasar', 'total', 'kecamatanList', 'ongkir', 'availableDiskons'));
    }

    public function processCheckout(Request $request)
    {
        // Jika metode pembayaran QRIS dan belum upload bukti, tampilkan halaman QRIS
        if ($request->metode_pembayaran === 'QRIS' && !$request->hasFile('bukti_pembayaran')) {
            $cartItems = CartItem::with(['produkPedagang.produk', 'produkPedagang.pedagang.pasar', 'cart'])
                ->whereIn('id', $request->selected_items)
                ->get();

            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $ongkir = \App\Models\ongkir::where('id_pasar', $cartItems->first()->produkPedagang->pedagang->pasar->id_pasar)
                ->where('kecamatan_tujuan', $request->kecamatan)
                ->first();

            $shippingCost = $ongkir->ongkir;
            if ($request->ongkir_type === 'prioritas') {
                $shippingCost += 10000;
            }

            $discountAmount = 0;
            $shippingDiscount = false;
            if ($request->kode_diskon) {
                $diskon = \App\Models\Diskon::where('kode_diskon', $request->kode_diskon)
                    ->where('aktif', true)
                    ->first();

                if ($diskon && $diskon->isValid()) {
                    if ($diskon->jenis_diskon === 'amount') {
                        $discountAmount = $diskon->max_diskon;
                        if ($discountAmount > $total) {
                            $discountAmount = $total;
                        }
                    } else if ($diskon->jenis_diskon === 'shipping') {
                        $shippingDiscount = true;
                    }
                }
            }

            $finalTotal = $total - $discountAmount;
            if (!$shippingDiscount) {
                $finalTotal += $shippingCost;
            }

            return view('customer.checkout-qris', [
                'request' => $request,
                'total' => $finalTotal
            ]);
        }

        // Validasi request
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:cart_items,id',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'metode_pembayaran' => 'required|in:COD,QRIS',
            'ongkir_type' => 'required|in:standar,prioritas',
            'bukti_pembayaran' => 'required_if:metode_pembayaran,QRIS|image|max:2048',
            'kode_diskon' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {
            $customer = Auth::user()->customer;
            if (!$customer) {
                return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai customer.');
            }

            // Get cart items with eager loading
            $cartItems = CartItem::with(['produkPedagang.produk', 'produkPedagang.pedagang.pasar', 'cart'])
                ->whereIn('id', $request->selected_items)
                ->get();

            // Calculate total
            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            // Get ongkir
            $ongkir = \App\Models\ongkir::where('id_pasar', $cartItems->first()->produkPedagang->pedagang->pasar->id_pasar)
                ->where('kecamatan_tujuan', $request->kecamatan)
                ->first();

            if (!$ongkir) {
                return redirect()->back()->with('error', 'Pengiriman tidak tersedia untuk kecamatan yang dipilih.');
            }

            // Calculate shipping cost
            $shippingCost = $ongkir->ongkir;
            if ($request->ongkir_type === 'prioritas') {
                $shippingCost += 10000;
            }

            // Apply discount if code is provided
            $discountAmount = 0;
            $shippingDiscount = false;
            if ($request->kode_diskon) {
                $diskon = \App\Models\Diskon::where('kode_diskon', $request->kode_diskon)
                    ->where('aktif', true)
                    ->first();

                if ($diskon && $diskon->isValid()) {
                    if ($diskon->jenis_diskon === 'amount') {
                        $discountAmount = $diskon->max_diskon;
                        if ($discountAmount > $total) {
                            $discountAmount = $total;
                        }
                    } else if ($diskon->jenis_diskon === 'shipping') {
                        $shippingDiscount = true;
                    }
                }
            }

            // Calculate final total
            $finalTotal = $total - $discountAmount;
            if (!$shippingDiscount) {
                $finalTotal += $shippingCost;
            }

            // Create order
            $order = Order::create([
                'customer_id' => $customer->id,
                'pasar_id' => $cartItems->first()->produkPedagang->pedagang->pasar->id_pasar,
                'total_harga' => $finalTotal,
                'ongkir_id' => $ongkir->id,
                'diskon' => $discountAmount,
                'kode_diskon' => $request->kode_diskon,
                'alamat' => $request->alamat,
                'kecamatan' => $request->kecamatan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->metode_pembayaran === 'QRIS' ? 'pending' : 'pending'
            ]);

            // Create order items (detail_pemesanans)

            foreach ($cartItems as $item) {
                if ($item->produkPedagang && $item->produkPedagang->produk) {
                    $order->items()->create([
                        'produk_pedagang_id' => $item->produk_pedagang_id,
                        'harga' => $item->price,
                        'jumlah' => $item->quantity,
                        'id_pasar' => $item->produkPedagang->pedagang->id_pasar,
                    ]);
                } else {
                    Log::error('Produk tidak ditemukan untuk cart item: ' . $item->id);
                }
            }

            // Handle payment proof if QRIS
            if ($request->metode_pembayaran === 'QRIS' && $request->hasFile('bukti_pembayaran')) {
                $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
                $order->update(['bukti_pembayaran' => $path]);
            }

            // Clear cart items
            CartItem::whereIn('id', $request->selected_items)->delete();

            return redirect()->route('riwayat.transaksi')->with('success', 'Pesanan berhasil dibuat!');
        });
    }

    public function ajaxCekOngkir(Request $request)
    {
        $ongkir = \App\Models\ongkir::where('id_pasar', $request->id_pasar)
            ->where('kecamatan_tujuan', $request->kecamatan)
            ->first();

        return response()->json([
            'ongkir' => $ongkir ? $ongkir->ongkir : null
        ]);
    }

    public function ajaxCekDiskon(Request $request)
    {
        $kodeDiskon = $request->kode_diskon;
        $total = $request->total;

        $diskon = \App\Models\Diskon::where('kode_diskon', $kodeDiskon)
            ->where('aktif', true)
            ->first();

        if (!$diskon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode diskon tidak valid'
            ]);
        }

        if (!$diskon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode diskon sudah tidak berlaku'
            ]);
        }

        if ($diskon->min_pembelian && $total < $diskon->min_pembelian) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian Rp ' . number_format($diskon->min_pembelian, 0, ',', '.')
            ]);
        }

        $discountAmount = 0;
        $shippingDiscount = false;

        if ($diskon->jenis_diskon === 'amount') {
            $discountAmount = $diskon->max_diskon;
            if ($discountAmount > $total) {
                $discountAmount = $total;
            }
            return response()->json([
                'success' => true,
                'message' => 'Diskon Rp ' . number_format($discountAmount, 0, ',', '.') . ' berhasil diterapkan',
                'discount_amount' => $discountAmount,
                'shipping_discount' => false
            ]);
        } else if ($diskon->jenis_diskon === 'shipping') {
            return response()->json([
                'success' => true,
                'message' => 'Gratis ongkir berhasil diterapkan',
                'discount_amount' => 0,
                'shipping_discount' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memproses diskon'
        ]);
    }
}
