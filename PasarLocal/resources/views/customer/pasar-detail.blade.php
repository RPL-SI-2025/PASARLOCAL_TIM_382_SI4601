<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                        <div class="mb-2">Stok: {{ $item->stok }} {{ $item->satuan }}</div>
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto"
                             onsubmit="return confirm('Yakin ingin menambahkan produk ini ke keranjang?');">
                            @csrf
                            <input type="hidden" name="produk_pedagang_id" value="{{ $item->id_produk_pedagang }}">
                            <div class="input-group mb-3">
                                <input type="number" name="quantity" class="form-control" value="1" min="1">
                                <span class="input-group-text">{{ $item->satuan }}</span>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2">Tambahkan ke Keranjang</button>
                        </form>
                        <a href="{{ route('produk.detail', $item->id_produk_pedagang) }}" class="btn btn-primary w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada produk di pasar ini.</div>
        @endforelse
    </div>

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif

</body>
</html> 