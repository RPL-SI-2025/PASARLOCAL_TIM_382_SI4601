<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pasar->nama_pasar }} - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .cart-icon {
            font-size: 1.2rem;
            color: #28a745;
        }
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            background-color: #dc3545;
            color: white;
            border-radius: 0.25rem;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .stock-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .stock-warning {
            color: #dc3545;
        }
        .stock-available {
            color: #198754;
        }
    </style>
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
                            <div class="mb-2 stock-info">
                                @if($item->stok > 0)
                                    <span class="stock-available">
                                        <i class="fas fa-check-circle me-1"></i>Stok tersedia: {{ $item->stok }}
                                    </span>
                                @else
                                    <span class="stock-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>Stok habis
                                    </span>
                                @endif
                            </div>
                            
                            @if($item->stok > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="produk_pedagang_id" value="{{ $item->id_produk_pedagang }}">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label for="quantity_{{ $item->id_produk_pedagang }}" class="form-label mb-0">Jumlah:</label>
                                        <input type="number" 
                                               class="form-control form-control-sm quantity-input" 
                                               id="quantity_{{ $item->id_produk_pedagang }}" 
                                               name="quantity" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $item->stok }}">
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning mb-0 mt-auto">
                                    Stok habis
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Belum ada produk di pasar ini.</div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
