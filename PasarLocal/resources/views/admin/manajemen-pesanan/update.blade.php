@extends('layouts.admin')

@section('content')
@php
    $order = (object)[
        'id' => 1,
        'customer' => (object)['nama_customer' => 'Mariska Harindra'],
        'total' => 120000,
        'status_pesanan' => 'Diproses',
        'pembayaran' => (object)['status_pembayaran' => 'Belum Lunas'],
    ];
@endphp

<div class="container py-4">
    <h2 class="mb-4">Update Status Pesanan #{{ $order->id }} (Dummy)</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Pelanggan:</strong> {{ $order->customer->nama_customer }}</p>
            <p><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ $order->pembayaran->status_pembayaran }}</p>
            <p><strong>Status Sekarang:</strong>
                <span class="badge
                    {{ $order->status_pesanan === 'Dikirim' ? 'bg-success' :
                       ($order->status_pesanan === 'Batal' ? 'bg-danger' :
                       ($order->status_pesanan === 'Selesai' ? 'bg-primary' : 'bg-warning')) }}">
                    {{ $order->status_pesanan }}
                </span>
            </p>
        </div>
    </div>

    <form>
        <div class="mb-3">
            <label for="status_pesanan" class="form-label">Ubah Status Pesanan</label>
            <select name="status_pesanan" id="status_pesanan" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="Diproses" {{ $order->status_pesanan === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Dikirim" {{ $order->status_pesanan === 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="Selesai" {{ $order->status_pesanan === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Batal" {{ $order->status_pesanan === 'Batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('admin.manajemen-pesanan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
