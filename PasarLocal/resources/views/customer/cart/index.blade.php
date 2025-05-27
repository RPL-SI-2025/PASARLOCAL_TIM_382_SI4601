@include('customer.partials.navbar')

<div class="container mx-auto px-10 py-10">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da; color: #721c24;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">Keranjang belanja Anda kosong</p>
            <a href="{{ route('customer.index') }}" class="btn btn-success mt-4">
                Belanja Sekarang
            </a>
        </div>

    @else
        @foreach($carts as $pasarId => $marketCarts)
            @php
                $cart = $marketCarts->first();
                $pasar = $cart->pasar;
                $cartItemIds = $cart->items->pluck('id')->toArray();
                $selectedItemIds = array_intersect(request()->input('selected_items', []), $cartItemIds);
                $selectedItemsTotal = $cart->items->whereIn('id', $selectedItemIds)->sum(function($item) {
                    return $item->quantity * $item->price;
                });
                $isAllSelected = count($cartItemIds) > 0 && count($selectedItemIds) === count($cartItemIds);
            @endphp
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-semibold">{{ $pasar->nama_pasar }}</h2>
                </div>
                <div class="p-4">
                    <form action="{{ route('cart.index') }}" method="GET" id="cart-form-{{ $pasarId }}">
                        @foreach(request()->input('selected_items', []) as $selectedId)
                            @if(!in_array($selectedId, $cartItemIds))
                                <input type="hidden" name="selected_items[]" value="{{ $selectedId }}">
                            @endif
                        @endforeach

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input select-all-checkbox" id="select-all-{{ $pasarId }}" 
                                   data-market-id="{{ $pasarId }}"
                                   {{ $isAllSelected ? 'checked' : '' }}>
                            <label class="form-check-label" for="select-all-{{ $pasarId }}">Pilih Semua Produk di {{ $pasar->nama_pasar }}</label>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="thead-light">
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left"></th>
                                        <th class="px-4 py-2 text-left"></th>
                                        <th class="px-4 py-1 text-left">Produk</th>
                                        <th class="px-4 py-2 text-left">Harga</th>
                                        <th class="px-4 py-2 text-left">Jumlah</th>
                                        <th class="px-4 py-2 text-left">Subtotal</th>
                                        <th class="px-4 py-2 text-left"></th>
                                    </tr>
                                </thead>
                                <tbody class="customtable" style="font-size: 10pt;">
                                    @foreach($cart->items as $item)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">
                                                <input type="checkbox" 
                                                       name="selected_items[]" 
                                                       value="{{ $item->id }}" 
                                                       form="cart-form-{{ $pasarId }}"
                                                       onchange="this.form.submit()"
                                                       class="item-checkbox item-checkbox-{{ $pasarId }}"
                                                       {{ in_array($item->id, $selectedItemIds) ? 'checked' : '' }}>
                                            </td>
                                            <td class="px-4 py-2">
                                                <img src="{{ asset('uploads_produk/' . $item->produkPedagang->produk->gambar) }}"
                                                     alt="{{ $item->produkPedagang->produk->nama_produk }}"
                                                     class="w-12 h-12 object-cover rounded">
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="ml-0">
                                                    <p class="font-medium">{{ $item->produkPedagang->produk->nama_produk }}</p>
                                                    <p class="text-sm text-gray-500">{{ $item->produkPedagang->pedagang->nama_pedagang }}</p>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2">
                                                <form action="{{ route('cart.update-quantity', $item) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                           min="1" class="w-20 border rounded px-2 py-1">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm ml-2">
                                                        Perbarui
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-4 py-2 font-semibold text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">
                                                <form action="{{ route('cart.remove-item', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Item">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                {{-- ✅ Total dan tombol Checkout di sisi kanan --}}
                <div class="mt-4 d-flex flex-column align-items-end">
                    <p class="text-lg font-semibold mb-0">Total</p>
                    <p class="text-lg font-semibold mb-2">Rp {{ number_format($selectedItemsTotal, 0, ',', '.') }}</p>
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form-{{ $pasarId }}">
                        @csrf
                        {{-- Include hidden inputs for selected items for THIS market --}}
                        @foreach($selectedItemIds as $selectedId)
                            @if(in_array($selectedId, $cartItemIds)) {{-- Ensure only selected items from this market are included --}}
                                <input type="hidden" name="selected_items[]" value="{{ $selectedId }}">
                            @endif
                        @endforeach
                        <button type="submit"
                           class="btn btn-success text-white px-6 py-2 rounded hover:bg-green-600">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>

{{-- JavaScript checkbox select all --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckboxes = document.querySelectorAll('.select-all-checkbox');

        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const marketId = this.dataset.marketId;
                const itemCheckboxes = document.querySelectorAll('.item-checkbox-' + marketId);
                itemCheckboxes.forEach(itemCheckbox => {
                    itemCheckbox.checked = this.checked;
                });
                document.getElementById('cart-form-' + marketId).submit();
            });
        });
    });
</script>

{{-- Tombol kembali --}}
<a href="{{ url()->previous() }}" class="btn btn-secondary float-button" style="position: fixed; bottom: 20px; left: 20px; z-index: 1000;">
    <i class="fas fa-arrow-left me-2"></i> Kembali
</a>
