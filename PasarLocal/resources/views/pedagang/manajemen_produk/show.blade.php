@extends('pedagang.partials.navbar')

@section('title', 'Detail Produk - PasarLocal')

@section('styles')
<style>
    .content-wrapper {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .detail-container {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin: 0;
        width: 100%;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: white;
        background: #28a745;
        padding: 15px 30px;
        border-radius: 10px 10px 0 0;
        margin: -30px -30px 30px -30px;
    }

    .detail-content {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .product-image {
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-group {
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: 500;
        color: #666;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 16px;
        color: #333;
    }

    .btn-kembali {
        display: inline-block;
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.2s;
        float: right;
    }

    .btn-kembali:hover {
        background-color: #5a6268;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm mt-4" style="border: 1.5px solid #28a745;">
                <div class="card-header bg-success text-white fw-bold" style="font-size:1.3rem;">Detail Produk</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-3 mb-md-0">
                            <img src="{{ asset('uploads_produk/' . $produkPedagang->foto_produk) }}" alt="Foto Produk" style="width: 320px; height: 220px; object-fit: cover; border-radius: 10px; border:1px solid #ccc;">
                        </div>
                        <div class="col-md-7">
                            <table class="table table-borderless mb-0" style="font-size:1.1rem;">
                                <tr>
                                    <th class="text-end" style="width: 140px;">Nama Produk:</th>
                                    <td>{{ $produkPedagang->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Kategori:</th>
                                    <td>{{ $produkPedagang->produk->kategori->nama_kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Stok:</th>
                                    <td>{{ $produkPedagang->stok }}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Deskripsi:</th>
                                    <td>{{ $produkPedagang->produk->deskripsi_produk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Harga:</th>
                                    <td class="fw-bold text-success">Rp {{ number_format($produkPedagang->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-end">Jumlah per Satuan:</th>
                                    <td>
                                        @if($produkPedagang->jumlah_satuan && $produkPedagang->satuan)
                                            {{ $produkPedagang->jumlah_satuan }} {{ $produkPedagang->satuan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('pedagang.manajemen_produk.index') }}" class="btn btn-secondary px-4 py-2 fw-bold">Kembali ke Daftar Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
