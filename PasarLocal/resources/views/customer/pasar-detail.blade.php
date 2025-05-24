<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @include('customer.partials.navbar')
    <div class="container py-4">
    <h2 class="mb-4">{{ $pasar->nama_pasar }}</h2>
    <p class="mb-4">{{ $pasar->alamat }}</p>
    <div class="row">
        @forelse($produkPedagang as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden;">
                        <img src="{{ asset('uploads_produk/' . $item->produk->gambar) }}"
                            class="card-img-top img-fluid"
                            alt="{{ $item->produk->nama_produk }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $item->produk->nama_produk }}</h6>
                        <div class="mb-2">Pedagang: {{ $item->pedagang->nama_pemilik }}</div>
                        <div class="mb-2">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                        <a href="#" class="btn btn-success mt-auto w-100">Lihat Produk</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada produk di pasar ini.</div>
        @endforelse
    </div>

</body>
</html>
