@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    @if($carts->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">Keranjang belanja Anda kosong</p>
            <a href="{{ route('produk.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Belanja Sekarang
            </a>
        </div>
    @else
        @foreach($carts as $pasarId => $marketCarts)
            @php
                $cart = $marketCarts->first();
                $pasar = $cart->pasar;
            @endphp
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-semibold">{{ $pasar->nama_pasar }}</h2>
                </div>
                
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left">Produk</th>
                                    <th class="px-4 py-2 text-left">Harga</th>
                                    <th class="px-4 py-2 text-left">Jumlah</th>
                                    <th class="px-4 py-2 text-left">Subtotal</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center">
                                                <img src="{{ asset('storage/' . $item->produkPedagang->produk->gambar) }}" 
                                                     alt="{{ $item->produkPedagang->produk->nama_produk }}"
                                                     class="w-16 h-16 object-cover rounded">
                                                <div class="ml-4">
                                                    <p class="font-medium">{{ $item->produkPedagang->produk->nama_produk }}</p>
                                                    <p class="text-sm text-gray-500">{{ $item->produkPedagang->pedagang->nama_pedagang }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">
                                            <form action="{{ route('cart.update-quantity', $item) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                       min="1" class="w-20 border rounded px-2 py-1">
                                                <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">
                                            <form action="{{ route('cart.remove-item', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold">Total: Rp {{ number_format($cart->total, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('checkout.index', ['pasar_id' => $pasar->id]) }}" 
                               class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 