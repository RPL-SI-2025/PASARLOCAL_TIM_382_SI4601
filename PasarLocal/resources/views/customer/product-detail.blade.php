@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('uploads_produk/' . $produk->gambar) }}"
                class="img-fluid rounded"
                alt="{{ $produk->nama_produk }}"
                style="width: 100%; height: 400px; object-fit: cover;">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">{{ $produk->nama_produk }}</h2>
            
            <div class="mb-4">
                <h5>Deskripsi Produk:</h5>
                <p>{{ $produk->deskripsi_produk ?? 'Tidak ada deskripsi produk.' }}</p>
            </div>

            @if($produkPedagangs->count() > 0)
                <h5>Tersedia di Pasar:</h5>
                <ul class="list-group mb-4">
                    @foreach($produkPedagangs as $item)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $item->pedagang->pasar->nama_pasar ?? 'Pasar tidak diketahui' }}</strong> - {{ $item->pedagang->nama_pemilik ?? 'Pedagang tidak diketahui' }}
                                    <br>
                                    Harga: <span class="text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}/{{ $item->satuan }}</span>
                                    <br>
                                    Stok: {{ $item->stok }}
                                </div>
                                @if($item->stok > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="produk_pedagang_id" value="{{ $item->id_produk_pedagang }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            + Keranjang
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-warning text-dark">Stok Habis</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning">
                    Produk ini tidak tersedia di pasar mana pun saat ini.
                </div>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection 