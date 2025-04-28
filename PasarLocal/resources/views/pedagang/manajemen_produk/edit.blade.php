@extends('pedagang.layouts.app')

@section('title', 'Edit Produk - PasarLocal')

@section('styles')
<style>
    .content-wrapper {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .form-container {
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

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 10px;
        color: #333;
    }

    .form-control, .form-select {
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        height: auto;
    }

    .btn-action {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .btn-update {
        background-color: #28a745;
        color: white;
    }

    .btn-update:hover {
        background-color: #218838;
        color: white;
    }

    .btn-batal {
        background-color: #6c757d;
        color: white;
    }

    .btn-batal:hover {
        background-color: #5a6268;
        color: white;
    }

    #preview-gambar img {
        max-width: 300px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-radius: 8px 0 0 8px;
        border: 1px solid #ddd;
        border-right: none;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    .button-container {
        margin-top: 30px;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm mt-4" style="border: 1.5px solid #28a745;">
                <div class="card-header bg-success text-white fw-bold" style="font-size:1.3rem;">Edit Produk</div>
                <div class="card-body">
                    <form action="{{ route('pedagang.update-produk', $produk_pedagang->id_produk_pedagang) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" value="{{ $produk_pedagang->produk->nama_produk }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" rows="2" readonly>{{ $produk_pedagang->produk->deskripsi_produk }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Kategori</label>
                            <input type="text" class="form-control" value="{{ $produk_pedagang->produk->kategori->nama_kategori ?? '-' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="foto_produk">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            <img src="{{ asset('uploads_produk/' . $produk_pedagang->foto_produk) }}" style="width: 240px; height: 180px; object-fit: cover; border-radius: 8px; border:1px solid #ccc;">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stok" value="{{ $produk_pedagang->stok }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="harga" value="{{ $produk_pedagang->harga }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah per Satuan</label>
                                <input type="number" class="form-control" name="jumlah_satuan" value="{{ $produk_pedagang->jumlah_satuan }}" min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Satuan</label>
                                <select class="form-select" name="satuan">
                                    <option value="">Pilih Satuan</option>
                                    <option value="gram" {{ $produk_pedagang->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
                                    <option value="kg" {{ $produk_pedagang->satuan == 'kg' ? 'selected' : '' }}>Kilogram</option>
                                    <option value="pcs" {{ $produk_pedagang->satuan == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pedagang.manajemen-produk') }}" class="btn btn-secondary px-4 py-2 fw-bold">Kembali</a>
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('id_produk').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const gambar = selectedOption.getAttribute('data-gambar');
    const previewImg = document.querySelector('#preview-gambar img');
    
    if (gambar) {
        previewImg.src = '/uploads_produk/' + gambar;
    } else {
        previewImg.src = 'https://via.placeholder.com/300x200?text=No+Image';
    }
});
</script>
@endsection 