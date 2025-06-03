<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan #{{ $order->id }} - PasarLocal</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .btn-hijau {
            background-color: #28a745;
            color: white;
        }
        .btn-hijau:hover {
            background-color: #218838;
            color: white;
        }
        .order-status-badge {
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 5px;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>

    @include('admin.partials.navbar')

    <div class="container py-4">
        <h2>Detail Pesanan #{{ $order->id }}</h2>
        <div class="card shadow-sm mt-3" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Pelanggan: {{ $order->customer->nama_customer }}</h5>
                <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p><strong>Status Bayar:</strong> {{ $order->status }}</p>
                <p><strong>Waktu Pemesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</p>
                {{-- Tampilkan bukti pembayaran jika ada dan metode QRIS --}}
                @if ($order->metode_pembayaran === 'QRIS' && $order->bukti_pembayaran)
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="{{ asset($order->bukti_pembayaran) }}" 
                         alt="Bukti Pembayaran" 
                         class="img-fluid mb-3" 
                         style="max-width: 200px; cursor: pointer;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#buktiPembayaranModal">
                @endif
                <p><strong>Ongkir:</strong> {{ $order->ongkir->ongkir ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $order->alamat ?? '-' }}</p>
                <p><strong>Kecamatan:</strong> {{ $order->kecamatan ?? '-' }}</p>
                <form action="{{ route('admin.manajemen-pesanan.update', $order->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <label for="status" class="form-label"><strong>Status Pesanan</strong></label>
                    <select name="status" id="status_pesanan" class="form-select" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-hijau mt-3">Update Status</button>
                </form>
                <a href="{{ route('admin.manajemen-pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title">Detail Produk yang Dibeli</h5>
                <ul class="list-group">
                    @foreach($order->detailPemesanans as $detail)
                        <li class="list-group-item d-flex align-items-center">
                            @if ($detail->produkPedagang && $detail->produkPedagang->produk)
                                <img src="{{ asset('uploads_produk/' . $detail->produkPedagang->produk->gambar) }}" class="img-produk me-3 border" alt="{{ $detail->produkPedagang->produk->nama_produk }}" style="width:60px;height:60px;">
                            @else
                                <img src="{{ asset('default.jpg') }}" class="img-produk me-3 border" alt="Produk tidak ditemukan" style="width:60px;height:60px;">
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $detail->produkPedagang->produk->nama_produk ?? '-' }}</h6>
                                <div class="text-muted small">{{ $detail->jumlah }} barang x Rp{{ number_format($detail->harga, 0, ',', '.') }}</div>
                                <div class="text-muted small">Pedagang: {{ $detail->produkPedagang->pedagang->nama_toko ?? '-' }}</div>
                                <div class="text-muted small">Pasar: {{ $detail->produkPedagang->pedagang->pasar->nama_pasar ?? '-' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fs-6 fw-bold text-success">
                                    Rp{{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Modal untuk zoom bukti pembayaran --}}
    <div class="modal fade" id="buktiPembayaranModal" tabindex="-1" aria-labelledby="buktiPembayaranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiPembayaranModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    @if ($order->metode_pembayaran === 'QRIS' && $order->bukti_pembayaran)
                        <img src="{{ asset($order->bukti_pembayaran) }}" class="img-fluid" alt="Bukti Pembayaran">
                    @else
                        <p>Tidak ada bukti pembayaran yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>
