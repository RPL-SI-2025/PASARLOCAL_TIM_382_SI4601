<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 2px;
        }
        .card {
            border: 1.5px solid #28a745;
        }
        .card-header {
            background-color: #28a745;
            color: white;
        }
        .form-label {
            color: #495057;
        }
        .btn-secondary, .btn-success {
            font-weight: bold;
        }
        .img-preview {
            max-height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body>
@include('admin.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Produk</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Gambar Produk:</label><br>
                    @if($produk->gambar)
                        <img src="{{ url('uploads_produk/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="img-fluid img-thumbnail img-preview">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid img-thumbnail img-preview" alt="No Image">
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk:</label>
                        <p class="form-control-plaintext">{{ $produk->nama_produk }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori:</label>
                        <p class="form-control-plaintext">{{ $produk->kategori->nama_kategori }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <p class="form-control-plaintext">{{ $produk->deskripsi_produk ?: 'Deskripsi tidak tersedia.' }}</p>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.manajemen-produk.index') }}" class="btn btn-secondary">Kembali ke Daftar Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
