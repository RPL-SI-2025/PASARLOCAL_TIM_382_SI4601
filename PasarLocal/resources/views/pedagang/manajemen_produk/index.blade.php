@extends('pedagang.layouts.app')

@section('title', 'Manajemen Produk - PasarLocal')

@section('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 15px;
        padding: 15px;
    }

    .table th:first-child {
        border-top-left-radius: 10px;
    }

    .table th:last-child {
        border-top-right-radius: 10px;
    }

    .table tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }

    .table tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }

    .table td {
        vertical-align: middle;
        font-size: 15px;
        padding: 20px;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-action {
        padding: 8px 12px;
        font-size: 14px;
        margin: 0 3px;
        min-width: 100px;
    }

    .btn-action i {
        margin-right: 5px;
    }

    .table-container {
        margin: 25px 0;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        background: white;
        padding: 0;
        overflow: hidden;
    }

    .search-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .btn-hijau {
        padding: 10px 20px;
        font-size: 15px;
    }

    .header-section {
        margin-bottom: 30px;
    }

    .header-section h2 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .btn-lihat {
        background-color: #17a2b8;
        color: white;
        border-radius: 5px;
    }

    .btn-lihat:hover {
        background-color: #138496;
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #000;
        border-radius: 5px;
    }

    .btn-edit:hover {
        background-color: #e0a800;
        color: #000;
    }

    .btn-hapus {
        background-color: #dc3545;
        color: white;
        border-radius: 5px;
    }

    .btn-hapus:hover {
        background-color: #c82333;
        color: white;
    }

    .main-content {
        padding: 0 30px;
    }

    .table-wrapper {
        overflow: hidden;
        border-radius: 10px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: none;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .judul-besar {
        font-size: 3.0rem !important;
        font-weight: 800 !important;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="fw-bold" style="font-size:2.8rem; letter-spacing:-1px; margin-top:32px;">Manajemen Produk</h1>
        </div>
    </div>
    <div class="row mb-4 justify-content-end">
        <div class="col-auto">
            <a href="{{ route('pedagang.manajemen_produk.create') }}" class="btn btn-success fw-bold" style="font-size:1.1rem; min-width:180px;">+ Tambah Produk</a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-3 bg-white rounded shadow-sm" style="width:100%; max-width:100%; margin:auto;">
                <form class="row g-0 align-items-center" method="GET" action="{{ route('pedagang.manajemen_produk.index') }}">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="kategori">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered bg-white rounded shadow-sm align-middle">
                    <thead class="align-middle text-center">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkPedagang as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('uploads_produk/' . $item->foto_produk) }}" alt="Foto {{ $item->produk->nama_produk }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td class="fw-bold">{{ $item->produk->nama_produk }}</td>
                                <td>{{ $item->produk->kategori->nama_kategori ?? '-' }}</td>
                                <td class="text-center">{{ $item->stok }}</td>
                                <td class="fw-bold text-success">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('pedagang.detail-produk', $item->id_produk_pedagang) }}" class="btn btn-info btn-sm fw-bold" style="min-width:60px;">Lihat</a>
                                        <a href="{{ route('pedagang.edit-produk', $item->id_produk_pedagang) }}" class="btn btn-warning btn-sm fw-bold" style="min-width:60px;">Edit</a>
                                        <form action="{{ route('pedagang.delete-produk', $item->id_produk_pedagang) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm fw-bold" style="min-width:60px;" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
