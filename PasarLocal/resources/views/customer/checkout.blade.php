@include('customer.partials.navbar')

<div class="container-fluid px-4 py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="mb-4 fw-bold text-success">Checkout</h3>
                    <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        {{-- Hidden input untuk selected_items --}}
                        @foreach($cartItems as $item)
                            <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                        @endforeach

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pasar</label>
                            <input type="text" class="form-control" value="{{ $pasar->nama_pasar ?? '-' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Produk yang Dibeli</label>
                            <ul class="list-group">
                                @foreach($cartItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->produkPedagang->produk->nama_produk }}</strong> x {{ $item->quantity }}<br>
                                            <small>Rp {{ number_format($item->price, 0, ',', '.') }} / item</small>
                                        </div>
                                        <span>Subtotal: Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Pengiriman</label>
                            <input type="text" class="form-control" name="alamat" value="{{ old('alamat', $customer->alamat) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kecamatan</label>
                            <select class="form-select" name="kecamatan" id="kecamatan" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatanList as $kec)
                                    <option value="{{ $kec }}" {{ old('kecamatan', $customer->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select class="form-select" name="metode_pembayaran" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="COD" {{ old('metode_pembayaran') == 'COD' ? 'selected' : '' }}>Cash on Delivery</option>
                                <option value="QRIS" {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kode Diskon</label>
                            <div class="input-group">
                                <select class="form-select" name="kode_diskon" id="kode_diskon">
                                    <option value="">Pilih Diskon</option>
                                    @foreach($availableDiskons as $diskon)
                                        <option value="{{ $diskon->kode_diskon }}" 
                                                data-jenis="{{ $diskon->jenis_diskon }}"
                                                data-max="{{ $diskon->max_diskon }}"
                                                data-min="{{ $diskon->min_pembelian }}">
                                            {{ $diskon->nama_diskon }} 
                                            @if($diskon->jenis_diskon === 'amount')
                                                - Potongan Rp {{ number_format($diskon->max_diskon, 0, ',', '.') }}
                                            @else
                                                - Gratis Ongkir
                                            @endif
                                            @if($diskon->min_pembelian)
                                                (Min. Rp {{ number_format($diskon->min_pembelian, 0, ',', '.') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-success" onclick="applyDiscount()">Terapkan</button>
                            </div>
                            <div id="discount-info" class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ongkir</label>
                            @if($ongkir)
                                <select class="form-select" name="ongkir_type" id="ongkir_type" required>
                                    <option value="standar">Standar (Rp {{ number_format($ongkir->ongkir, 0, ',', '.') }})</option>
                                    <option value="prioritas">Prioritas (Rp {{ number_format($ongkir->ongkir + 10000, 0, ',', '.') }})</option>
                                </select>
                                <input type="hidden" name="ongkir" id="ongkir" value="{{ $ongkir->ongkir }}">
                            @else
                                <select class="form-select is-invalid" disabled>
                                    <option>Pengiriman tidak tersedia</option>
                                </select>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Total Harga</label>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Diskon:</span>
                                <span id="discount-amount">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Ongkir:</span>
                                <span id="shipping-amount">Rp {{ number_format($ongkir->ongkir ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold" id="totalHarga">Rp {{ number_format($total + ($ongkir->ongkir ?? 0), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success w-100" onclick="konfirmasiPesan()" @if(!$ongkir) disabled @endif>Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tombol kembali -->
<a href="{{ route('checkout.show', ['selected_items' => request('selected_items')]) }}" class="btn btn-secondary float-button" style="position: fixed; bottom: 20px; left: 20px; z-index: 1000;">
    <i class="fas fa-arrow-left me-2"></i> Kembali
</a>

{{-- Select2 & Script --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#kecamatan').select2({
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
            width: '100%'
        });

        $('#kode_diskon').select2({
            placeholder: 'Pilih Diskon',
            allowClear: true,
            width: '100%'
        });

        // Store variables
        const idPasar = "{{ $pasar->id_pasar ?? '' }}";
        const total = parseInt("{{ $total }}");
        let discountAmount = 0;
        let shippingDiscount = false;

        // Function to update total price
        function updateTotalHarga() {
            let ongkir = parseInt($('#ongkir').val());
            let harga = total;
            
            // Apply shipping discount if available
            if (shippingDiscount) {
                ongkir = 0;
            }
            
            // Apply regular discount
            let finalTotal = harga - discountAmount;
            
            // Add shipping cost
            if ($('#ongkir_type').val() === 'prioritas') {
                ongkir += 10000;
            }
            finalTotal += ongkir;

            // Update display
            $('#subtotal').text('Rp ' + harga.toLocaleString('id-ID'));
            $('#discount-amount').text('Rp ' + discountAmount.toLocaleString('id-ID'));
            $('#shipping-amount').text('Rp ' + ongkir.toLocaleString('id-ID'));
            $('#totalHarga').text('Rp ' + finalTotal.toLocaleString('id-ID'));
        }

        // Function to set shipping as unavailable
        function setOngkirUnavailable() {
            $('#ongkir_type').html('<option>Pengiriman tidak tersedia</option>');
            $('#ongkir_type').prop('disabled', true);
            $('#totalHarga').addClass('is-invalid').val('Pengiriman tidak tersedia');
            $('#checkoutForm button[type=button]').prop('disabled', true);
        }

        // Handle kecamatan change
        $('#kecamatan').on('change', function() {
            const kecamatan = $(this).val();
            if (!kecamatan || !idPasar) {
                setOngkirUnavailable();
                return;
            }

            $.getJSON("{{ route('ajax.cek-ongkir') }}", { 
                id_pasar: idPasar, 
                kecamatan: kecamatan 
            }, function(res) {
                if (res.ongkir !== null) {
                    $('#ongkir_type').prop('disabled', false);
                    $('#ongkir').val(res.ongkir);
                    $('#ongkir_type').html(
                        '<option value="standar">Standar (Rp ' + res.ongkir.toLocaleString('id-ID') + ')</option>' +
                        '<option value="prioritas">Prioritas (Rp ' + (parseInt(res.ongkir)+10000).toLocaleString('id-ID') + ')</option>'
                    );
                    updateTotalHarga();
                    $('#totalHarga').removeClass('is-invalid');
                    $('#checkoutForm button[type=button]').prop('disabled', false);
                } else {
                    setOngkirUnavailable();
                }
            });
        });

        // Handle ongkir type change
        $('#ongkir_type').on('change', function() {
            updateTotalHarga();
        });

        // Handle discount selection change
        $('#kode_diskon').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const jenisDiskon = selectedOption.data('jenis');
            const maxDiskon = selectedOption.data('max');
            const minPembelian = selectedOption.data('min');

            if (!jenisDiskon) {
                discountAmount = 0;
                shippingDiscount = false;
                updateTotalHarga();
                return;
            }

            if (minPembelian && total < minPembelian) {
                $('#discount-info').html('<span class="text-danger">Minimal pembelian Rp ' + minPembelian.toLocaleString('id-ID') + '</span>');
                discountAmount = 0;
                shippingDiscount = false;
                updateTotalHarga();
                return;
            }

            if (jenisDiskon === 'amount') {
                discountAmount = Math.min(maxDiskon, total);
                shippingDiscount = false;
                $('#discount-info').html('<span class="text-success">Diskon Rp ' + discountAmount.toLocaleString('id-ID') + ' berhasil diterapkan</span>');
            } else if (jenisDiskon === 'shipping') {
                discountAmount = 0;
                shippingDiscount = true;
                $('#discount-info').html('<span class="text-success">Gratis ongkir berhasil diterapkan</span>');
            }

            updateTotalHarga();
        });
    });

    // Function to apply discount
    function applyDiscount() {
        const selectedOption = $('#kode_diskon option:selected');
        if (!selectedOption.val()) {
            $('#discount-info').html('<span class="text-danger">Pilih diskon terlebih dahulu</span>');
            return;
        }

        // Trigger the change event to apply the discount
        $('#kode_diskon').trigger('change');
        }

    // Confirmation before submit
    function konfirmasiPesan() {
        const konfirmasi = confirm('Apakah Anda yakin ingin memesan produk ini?');
        if (konfirmasi) {
            document.getElementById('checkoutForm').submit();
        }
    }
</script> 