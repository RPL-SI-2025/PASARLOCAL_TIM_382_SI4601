@include('customer.partials.navbar')
<meta name="csrf-token" content="{{ csrf_token() }}">

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

    @php
        $allItemsCount = $carts->flatten()->reduce(function($carry, $cart) {
            return $carry + ($cart->items->count() ?? 0);
        }, 0);
    @endphp
    @if($carts->isEmpty() || $allItemsCount === 0)
        <div class="bg-white rounded-lg shadow p-6 text-center my-5">
            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Cart Empty" style="width:100px;opacity:0.5;">
            <h3 class="mt-3 mb-2 text-muted">Keranjang belanja Anda kosong</h3>
            <p class="text-muted mb-4">Yuk, mulai belanja produk kebutuhanmu di PasarLocal!</p>
            <a href="{{ route('customer.index') }}" class="btn btn-success btn-lg px-4">
                Belanja Sekarang
            </a>
        </div>
    @else
        @foreach($carts as $pasarId => $marketCarts)
            @php
                $cart = $marketCarts->first();
                if ($cart->items->isEmpty()) continue;
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
                                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="ml-0">
                                                    <p class="font-medium">{{ $item->produkPedagang->produk->nama_produk }}</p>
                                                    <p class="text-sm text-gray-500">{{ $item->produkPedagang->pedagang->nama_pedagang }}</p>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}/{{ $item->produkPedagang->satuan }}</td>
                                            <td class="px-4 py-2">
                                                <div class="flex items-center">
                                                    <form action="{{ route('cart.update-quantity', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 border rounded px-2 py-1 quantity-input">
                                                        <button type="submit" class="btn btn-outline-primary btn-sm ml-2">
                                                            <i class="fas fa-sync-alt me-1"></i> Perbarui
                                                        </button>
                                                    </form>
                                                </div>
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
                    <form action="{{ route('checkout.show') }}" method="GET" id="checkout-form-{{ $pasarId }}">
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

{{-- JavaScript for Cart Functionality --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateMarketTotal(marketId) {
        const marketGroup = document.querySelector(`[data-market-id="${marketId}"]`).closest('.bg-white');
        let selectedTotal = 0;
        const checkedItems = marketGroup.querySelectorAll('input[type="checkbox"]:checked');
        checkedItems.forEach(checkbox => {
            const itemRow = checkbox.closest('tr');
            if (itemRow) {
                const subtotalText = itemRow.querySelector('td:nth-last-child(2)').textContent;
                const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, '')) || 0;
                selectedTotal += subtotal;
            }
        });
        const totalElem = marketGroup.querySelector('.text-lg.font-semibold.mb-2');
        if (totalElem) {
            totalElem.textContent = 'Rp ' + formatNumber(selectedTotal);
        }
    }

    function showMessage(message, isSuccess = true) {
        // Remove existing alerts
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${isSuccess ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '1050';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Handle quantity update forms
        document.querySelectorAll('.quantity-update-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Ambil input number di baris yang sama
                const row = form.closest('tr');
                const qtyInput = row.querySelector('input.quantity-input');
                const hiddenInput = form.querySelector('input.quantity-hidden-input');
                if (qtyInput && hiddenInput) {
                    hiddenInput.value = qtyInput.value;
                }
            });
        });

        // Handle select all checkboxes
        const selectAllCheckboxes = document.querySelectorAll('.select-all-checkbox');
        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const marketId = this.dataset.marketId;
                const itemCheckboxes = document.querySelectorAll('.item-checkbox-' + marketId);
                const isChecked = this.checked;

                itemCheckboxes.forEach(itemCheckbox => {
                    itemCheckbox.checked = isChecked;
                });

                updateMarketTotal(marketId);
            });
        });

        // Handle individual item checkboxes
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const marketId = this.closest('.bg-white').querySelector('.select-all-checkbox').dataset.marketId;
                const itemCheckboxes = document.querySelectorAll('.item-checkbox-' + marketId);
                const selectAllCheckbox = document.querySelector(`[data-market-id="${marketId}"]`);

                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = Array.from(itemCheckboxes).every(cb => cb.checked);
                }

                updateMarketTotal(marketId);
            });
        });

        // Initially update all market totals
        selectAllCheckboxes.forEach(checkbox => {
            updateMarketTotal(checkbox.dataset.marketId);
        });

        // Handle checkout form submit: ambil semua checkbox produk yang dicentang di pasar ini
        document.querySelectorAll('form[id^="checkout-form-"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                // Hapus input hidden selected_items[] sebelumnya
                form.querySelectorAll('input[name="selected_items[]"]').forEach(el => el.remove());
                // Ambil semua checkbox produk yang dicentang di pasar ini
                const marketId = form.id.replace('checkout-form-', '');
                const checked = document.querySelectorAll('.item-checkbox-' + marketId + ':checked');
                if (checked.length === 0) {
                    e.preventDefault();
                    showMessage('Pilih produk yang ingin dibeli terlebih dahulu.', false);
                    return;
                }
                checked.forEach(cb => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'selected_items[]';
                    hidden.value = cb.value;
                    form.appendChild(hidden);
                });
            });
        });

        // Konfirmasi sebelum update quantity
        document.querySelectorAll('form.inline').forEach(function(form) {
            const updateBtn = form.querySelector('button[type="submit"]');
            if (updateBtn) {
                updateBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Perbarui Jumlah?',
                        text: 'Apakah Anda yakin ingin memperbarui jumlah produk ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, perbarui',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            setTimeout(function(){ window.location.reload(); }, 800);
                        }
                    });
                });
            }
        });
    });
</script>

{{-- Tombol kembali --}}
<a href="#" onclick="window.history.back(); return false;" class="btn btn-secondary float-button" style="position: fixed; bottom: 20px; left: 20px; z-index: 1000;">
    <i class="fas fa-arrow-left me-2"></i> Kembali
</a>
