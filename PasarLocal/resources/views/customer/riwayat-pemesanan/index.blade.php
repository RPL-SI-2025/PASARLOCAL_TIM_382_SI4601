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

        <form action="{{ route('riwayat.transaksi') }}" method="GET">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Filter Status:</label>
                    <select class="form-select" id="statusFilter" onchange="this.form.submit()" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $status == 'diproses' ? 'selected' : '' }}>Di proses</option>
                        <option value="dikirim" {{ $status == 'dikirim' ? 'selected' : '' }}>Di kirim</option>
                        <option value="selesai" {{ $status == 'selesai  ' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ $status == 'batal' ? 'selected' : '' }}>Di batalkan</option>
                        {{-- Add other statuses if needed --}}
                    </select>
                </div>
            </div>
        </form>

        {{-- Display session error messages --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($pemesanans->count())
            @foreach($pemesanans as $pemesanan)
                <div class="card-transaksi border p-4 mb-4 bg-white">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <div>
                            Belanja {{ $pemesanan->created_at->format('d M Y H:i') }}
                        </div>
                        <div>
                            <span class="badge-status bg-success text-white">{{ ucfirst($pemesanan->status) }}</span>
                            <span class="ms-2 text-secondary">INV/{{ $pemesanan->id }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @php
                            $firstDetail = $pemesanan->detailPemesanans->first();
                            $pasar = $firstDetail && $firstDetail->produkPedagang && $firstDetail->produkPedagang->pedagang && $firstDetail->produkPedagang->pedagang->pasar
                                ? $firstDetail->produkPedagang->pedagang->pasar : null;
                        @endphp
                        @if($pasar && $pasar->gambar)
                            <img src="{{ asset('uploads_pasar/' . $pasar->gambar) }}" class="img-produk me-3 border" alt="{{ $pasar->nama_pasar }}">
                        @else
                            <img src="{{ asset('default.jpg') }}" class="img-produk me-3 border" alt="Pasar tidak ditemukan">
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $pasar->nama_pasar ?? '-' }}</h6>
                            <div class="text-muted small">Total produk: {{ $pemesanan->detailPemesanans->count() }}</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Total Belanja</div>
                            <div class="fs-5 fw-bold text-success">
                                Rp{{ number_format($pemesanan->detailPemesanans->sum(function($d){return $d->jumlah * $d->harga;}), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <button class="btn btn-outline-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pemesanan->id }}">Detail</button>
                    </div>
                </div>
                <!-- Modal Detail -->
                <div class="modal fade" id="detailModal{{ $pemesanan->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $pemesanan->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $pemesanan->id }}">Detail Pemesanan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    @foreach($pemesanan->detailPemesanans as $detail)
                                        <li class="list-group-item d-flex align-items-center">
                                            @if ($detail->produkPedagang && $detail->produkPedagang->produk)
                                                <img src="{{ asset('uploads_produk/' . $detail->produkPedagang->produk->gambar) }}" class="img-produk me-3 border" alt="{{ $detail->produkPedagang->produk->nama_produk }}">
                                            @else
                                                <img src="{{ asset('default.jpg') }}" class="img-produk me-3 border" alt="Produk tidak ditemukan">
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $detail->produkPedagang->produk->nama_produk ?? '-' }}</h6>
                                                <div class="text-muted small">Toko: {{ $detail->produkPedagang->pedagang->nama_toko ?? '-' }}</div>
                                                <div class="text-muted small">Pedagang: {{ $detail->produkPedagang->pedagang->nama_pemilik ?? '-' }}</div>
                                                <div class="text-muted small">
                                                    {{ $detail->jumlah }} {{ $detail->produkPedagang->satuan ?? '-' }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="fs-6 fw-bold text-success">
                                                    Rp{{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}
                                                </div>
                                                @if(strtolower($pemesanan->status) === 'selesai')
                                                    @php
                                                        // Cari review yang cocok untuk detail pemesanan ini dalam koleksi review pemesanan
                                                        $existingReview = $pemesanan->reviews->firstWhere('produk_pedagang_id', $detail->produk_pedagang_id);
                                                    @endphp
                                                    <div class="d-flex flex-column align-items-end mt-2">
                                                        @if($existingReview)
                                                            {{-- Jika sudah ada review, tampilkan tombol Edit Ulas dan Hapus Ulas --}}
                                                            <a href="{{ route('customer.review.edit', ['review' => $existingReview->id]) }}" class="btn btn-outline-secondary btn-sm mb-1">Edit Ulas</a>
                                                            <form action="{{ route('customer.review.destroy', ['review' => $existingReview->id]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus review ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus Ulas</button>
                                                            </form>
                                                        @else
                                                            {{-- Jika belum ada review, tampilkan tombol Ulas --}}
                                                            <a href="{{ route('customer.review.create', ['pemesanan' => $pemesanan->id, 'produk' => $detail->produk_pedagang_id]) }}" class="btn btn-outline-success btn-sm">Ulas</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $pemesanans->links() }}
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
