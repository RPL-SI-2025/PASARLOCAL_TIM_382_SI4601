<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('customer.partials.navbar')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Detail Produk</h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-5 text-center mb-3 mb-md-0">
                            <img src="{{ asset('uploads_produk/' . $produkPedagang->produk->gambar) }}" class="img-fluid rounded" alt="{{ $produkPedagang->produk->nama_produk }}">
                        </div>
                        <div class="col-md-7">
                            <h5>{{ $produkPedagang->produk->nama_produk }}</h5>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($produkPedagang->harga, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Stok:</strong> {{ $produkPedagang->stok }} {{ $produkPedagang->satuan }}</p>
                            <p class="mb-1"><strong>Jumlah per Satuan:</strong> {{ $produkPedagang->jumlah_satuan }} {{ $produkPedagang->satuan }}</p>
                            <p class="mb-1"><strong>Deskripsi:</strong> {{ $produkPedagang->deskripsi }}</p>
                            <hr>
                            <h6 class="mt-3">Informasi Pedagang</h6>
                            <p class="mb-1"><strong>Nama Pedagang:</strong> {{ $produkPedagang->pedagang->nama_pemilik }}</p>
                            <p class="mb-1"><strong>Nama Toko:</strong> {{ $produkPedagang->pedagang->nama_toko }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html> 