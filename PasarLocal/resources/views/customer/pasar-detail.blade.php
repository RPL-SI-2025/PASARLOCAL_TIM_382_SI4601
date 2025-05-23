@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ $pasar->nama_pasar }}</h2>
    <p class="mb-4">{{ $pasar->alamat }}</p>
    <div class="row g-4">
        @forelse($produkPedagang as $item)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="{{ asset('uploads_produk/' . $item->produk->gambar) }}" class="card-img-top" alt="{{ $item->produk->nama_produk }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->produk->nama_produk }}</h6>
                        <div class="mb-2">Pedagang: {{ $item->pedagang->nama_pemilik }}</div>
                        <div class="mb-2">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                        <a href="#" class="btn btn-success w-100">Lihat Produk</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada produk di pasar ini.</div>
        @endforelse
    </div>
</div>
@endsection 