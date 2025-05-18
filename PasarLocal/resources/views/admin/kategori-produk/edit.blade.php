<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - PasarLocal</title>
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
        .btn-secondary, .btn-primary {
            font-weight: bold;
        }
        .custom-file {
            border: 1px solid #28a745;
            padding: 10px;
            border-radius: .375rem;
        }
    </style>
</head>
<body>
@include('admin.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Kategori Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kategori-produk.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Kategori (opsional)</label><br>
                    <div class="custom-file">
                    @if ($kategori->gambar)
                     <img src="{{ asset('storage/' . $kategori->gambar) }}" alt="Gambar Kategori" class="img-thumbnail mb-2" style="max-width: 200px;">
                    @endif

                    </div>
                    <input type="file" name="gambar" class="form-control mt-2" id="gambar">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
