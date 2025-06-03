<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Beri Review</title>
</head>
<body>
    @include('customer.partials.navbar')
    
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Beri Review</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6>Detail Produk yang Dipesan:</h6>
                            {{-- Debugging: Tampilkan nilai pedagang dan foto_produk --}}
                            {{-- {{ dd(['pedagang' => $produkPedagang->pedagang, 'foto_produk' => $produkPedagang->foto_produk]) }} --}}

                            @if ($produkPedagang->foto_produk)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('uploads_produk/' . $produkPedagang->foto_produk) }}" alt="Gambar Produk" class="img-fluid" style="max-width: 200px;">
                                </div>
                            @endif
                            <p class="mb-1"><strong>Pasar:</strong> {{ $produkPedagang->pedagang->pasar->nama_pasar }}</p>
                            <p class="mb-1"><strong>Pedagang:</strong> {{ $produkPedagang->pedagang->nama_toko }}</p>
                            <p class="mb-1"><strong>Nama Pemilik:</strong> {{ $produkPedagang->pedagang->nama_pemilik }}</p>
                            <p class="mb-1"><strong>Nama Produk:</strong> {{ $produkPedagang->produk->nama_produk }}</p>
                            @if ($detail)
                                <p class="mb-1"><strong>Harga Satuan:</strong> Rp {{ number_format($detail->harga, 0, ',', '.') }}/{{ $produkPedagang->satuan }}</p>
                                <p class="mb-1"><strong>Jumlah:</strong> {{ $detail->jumlah }} {{ $produkPedagang->satuan }}</p>
                                <p class="mb-1"><strong>Subtotal:</strong> Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</p>
                            @else
                                <p class="mb-1 text-danger">Detail pemesanan untuk produk ini tidak ditemukan.</p>
                            @endif
                        </div>

                        <form action="{{ route('customer.review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
                            <input type="hidden" name="produk_pedagang_id" value="{{ $produkPedagang->id_produk_pedagang }}">

                            <div class="mb-3">
                                <label for="feedback" class="form-label">Kritik / Saran</label>
                                <textarea class="form-control @error('feedback') is-invalid @enderror"
                                    id="feedback" name="feedback" rows="4" required>{{ old('feedback') }}</textarea>
                                @error('feedback')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('riwayat.transaksi') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Kirim Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>