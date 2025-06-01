@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('uploads_produk/' . $produkPedagang->produk->gambar) }}"
                class="img-fluid rounded"
                alt="{{ $produkPedagang->produk->nama_produk }}"
                style="width: 100%; height: 400px; object-fit: cover;">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">{{ $produkPedagang->produk->nama_produk }}</h2>
            <p class="text-muted mb-3">Pedagang: {{ $produkPedagang->pedagang->nama_pemilik }}</p>
            <p class="text-muted mb-3">Pasar: {{ $produkPedagang->pedagang->pasar->nama_pasar }}</p>
            
            <div class="mb-4">
                <h4 class="text-success mb-2">Rp {{ number_format($produkPedagang->harga, 0, ',', '.') }}</h4>
                <p class="text-muted">Stok: {{ $produkPedagang->stok }}</p>
            </div>

            <div class="mb-4">
                <h5>Deskripsi Produk:</h5>
                <p>{{ $produkPedagang->produk->deskripsi_produk ?? 'Tidak ada deskripsi produk.' }}</p>
            </div>

            @if($produkPedagang->stok > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="produk_pedagang_id" value="{{ $produkPedagang->id_produk_pedagang }}">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="1" min="1" max="{{ $produkPedagang->stok }}" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>
                </form>
            @else
                <div class="alert alert-warning">
                    Stok produk habis
                </div>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection 