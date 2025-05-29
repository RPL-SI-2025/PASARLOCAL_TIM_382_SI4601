
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
    <div class="container my-5">
        <h1 class="mb-4">Keranjang Belanja</h1>

        @if($carts->isEmpty())
            <div class="alert alert-info text-center">
                Keranjang belanja Anda kosong. <a href="{{ route('customer.index') }}" class="text-primary">Belanja Sekarang</a>
            </div>
        @else
            @foreach($carts as $pasarId => $marketCarts)
                @php
                    $cart = $marketCarts->first();
                    $pasar = $cart->pasar;
                @endphp
                <h4 class="mb-3">{{ $pasar->nama_pasar }}</h4>

                @foreach($cart->items as $item)
                <div class="card mb-3" style="max-width: 720px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('uploads_produk/' . $item->produkPedagang->produk->gambar) }}" class="img-fluid rounded-start" alt="{{ $item->produkPedagang->produk->nama_produk }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->produkPedagang->produk->nama_produk }}</h5>
                                <p class="card-text text-muted mb-1">Pedagang: {{ $item->produkPedagang->pedagang->nama_pedagang }}</p>
                                <p class="card-text mb-1">Harga: <strong>Rp {{ number_format($item->price, 0, ',', '.') }}</strong></p>
                                <p class="card-text mb-1">Subtotal: <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></p>

                                <div class="d-flex align-items-center mt-3">
                                    <form action="{{ route('cart.update-quantity', $item) }}" method="POST" class="d-flex align-items-center me-3">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm w-50 me-2">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.remove-item', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center mb-5" style="max-width: 720px;">
                    <h5>Total: Rp {{ number_format($cart->total, 0, ',', '.') }}</h5>
                    <a href="#" class="btn btn-success">Checkout</a>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
