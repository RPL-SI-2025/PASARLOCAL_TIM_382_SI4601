<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Riwayat Transaksi</title>
    <style>
        .card-transaksi {
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.2s ease-in-out;
        }

        .card-transaksi:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 0.35em 0.75em;
            border-radius: 999px;
        }

        .img-produk {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .btn-rounded {
            border-radius: 999px;
        }
    </style>
</head>
<body>
    @include('customer.partials.navbar')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">Riwayat Transaksi</h2>

        @if($transaksis->count())
            @foreach($transaksis as $transaksi)
                <div class="card-transaksi border p-4 mb-4 bg-white">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <div>
                            Belanja {{ $transaksi->created_at->format('d M Y') }}
                        </div>
                        <div>
                            <span class="badge-status bg-success text-white">{{ ucfirst($transaksi->status ?? 'selesai') }}</span>
                            <span class="ms-2 text-secondary">INV/{{ $transaksi->id }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <img src="{{ asset('uploads_produk/' . $transaksi->produkPedagang->produk->gambar) }}" class="img-fluid rounded-start" alt="{{ $transaksi->produkPedagang->produk->nama_produk }}"
                             alt="Foto Produk" class="img-produk me-3 border" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $transaksi->produkPedagang->produk->nama_produk ?? '-' }}</h6>
                            <div class="text-muted small">{{ $transaksi->quantity }} barang x Rp{{ number_format($transaksi->produkPedagang->harga ?? 0, 0, ',', '.') }}</div>
                            <div class="text-muted small">Pasar: {{ $transaksi->pasar->nama_pasar ?? '-' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Total Belanja</div>
                            <div class="fs-5 fw-bold text-success">
                                Rp{{ number_format(($transaksi->produkPedagang->harga ?? 0) * $transaksi->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <a href="#" class="btn btn-outline-success btn-sm btn-rounded">Ulas</a>
                        <a href="#" class="btn btn-success btn-sm btn-rounded">Beli Lagi</a>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <img src="{{ asset('images/no-transaction.png') }}" class="mb-3" width="120" alt="No transaction">
                <p class="fs-5 fw-semibold">Belum ada riwayat transaksi</p>
                <p class="small">Yuk mulai belanja dan lihat transaksi kamu di sini nanti!</p>
                <a href="{{ route('customer.index') }}" class="btn btn-success btn-rounded mt-2">Belanja Sekarang</a>
            </div>
        @endif
    </div>
</body>
</html>
