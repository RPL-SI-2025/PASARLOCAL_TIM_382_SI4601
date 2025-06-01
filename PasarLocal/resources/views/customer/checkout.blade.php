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
                            <input type="text" class="form-control" id="totalHarga" value="Rp {{ number_format($total + ($ongkir->ongkir ?? 0), 0, ',', '.') }}" readonly>
                        </div>

                        <button type="button" class="btn btn-success w-100" onclick="konfirmasiPesan()" @if(!$ongkir) disabled @endif>Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tombol kembali -->
<a href="{{ url()->previous() }}" class="btn btn-secondary float-button" style="position: fixed; bottom: 20px; left: 20px; z-index: 1000;">
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

        // Simpan id_pasar untuk AJAX
        var idPasar = "{{ $pasar->id_pasar ?? '' }}";
        var total = {{ $total }};

        // Saat kecamatan diubah, cek ongkir
        $('#kecamatan').on('change', function() {
            var kecamatan = $(this).val();
            if (!kecamatan || !idPasar) {
                setOngkirUnavailable();
                return;
            }
            $.getJSON("{{ route('ajax.cek-ongkir') }}", { id_pasar: idPasar, kecamatan: kecamatan }, function(res) {
                if (res.ongkir !== null) {
                    // Enable dropdown ongkir, update opsi dan total harga
                    $('#ongkir_type').prop('disabled', false);
                    $('#ongkir').val(res.ongkir);
                    $('#ongkir_type').html(
                        '<option value="standar">Standar (Rp ' + res.ongkir.toLocaleString('id-ID') + ')</option>' +
                        '<option value="prioritas">Prioritas (Rp ' + (parseInt(res.ongkir)+10000).toLocaleString('id-ID') + ')</option>'
                    );
                    updateTotalHarga();
                    $('#totalHarga').removeClass('is-invalid').val('Rp ' + (total + parseInt(res.ongkir)).toLocaleString('id-ID'));
                    $('#checkoutForm button[type=button]').prop('disabled', false);
                } else {
                    setOngkirUnavailable();
                }
            });
        });

        // Update total harga saat ongkir_type berubah
        $('#ongkir_type').on('change', function() {
            updateTotalHarga();
        });

        function updateTotalHarga() {
            let ongkir = parseInt($('#ongkir').val());
            let harga = total;
            if ($('#ongkir_type').val() === 'prioritas') {
                ongkir += 10000;
            }
            $('#totalHarga').val('Rp ' + (harga + ongkir).toLocaleString('id-ID'));
        }

        function setOngkirUnavailable() {
            $('#ongkir_type').html('<option>Pengiriman tidak tersedia</option>');
            $('#ongkir_type').prop('disabled', true);
            $('#totalHarga').addClass('is-invalid').val('Pengiriman tidak tersedia');
            $('#checkoutForm button[type=button]').prop('disabled', true);
        }
    });

    // Konfirmasi sebelum submit
    function konfirmasiPesan() {
        let konfirmasi = confirm('Apakah Anda yakin ingin memesan produk ini?');
        if (konfirmasi) {
            document.getElementById('checkoutForm').submit();
        }
    }
</script> 