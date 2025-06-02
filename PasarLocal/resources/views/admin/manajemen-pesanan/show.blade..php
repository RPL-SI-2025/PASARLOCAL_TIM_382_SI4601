@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h2>Detail Pesanan #{{ $pemesanan->id }}</h2>

    <a href="{{ route('admin.manajemen-pesanan.index') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Pesanan</a>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Pelanggan</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $pemesanan->customer->nama_customer }}</p>
            <p><strong>Email:</strong> {{ $pemesanan->customer->email ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $pemesanan->customer->alamat ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $pemesanan->customer->telepon ?? '-' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Detail Pesanan</strong>
        </div>
        <div class="card-body">
            @if($pemesanan->detailPemesanans->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemesanan->detailPemesanans as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>Detail pesanan tidak tersedia.</p>
            @endif

            <hr>
            <p><strong>Ongkir:</strong> Rp{{ number_format($pemesanan->ongkir->harga ?? 0, 0, ',', '.') }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $pemesanan->metode_pembayaran }}</p>
            <p><strong>Status Pesanan:</strong> {{ $pemesanan->status }}</p>
            <p><strong>Status Pembayaran:</strong> {{ $pemesanan->status_pembayaran }}</p>
            
            @if($pemesanan->bukti_pembayaran)
                <p><strong>Bukti Pembayaran:</strong></p>
                <img src="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 300px;">
            @else
                <p><strong>Bukti Pembayaran:</strong> Belum ada</p>
            @endif
        </div>
    </div>
</div>
@endsection
