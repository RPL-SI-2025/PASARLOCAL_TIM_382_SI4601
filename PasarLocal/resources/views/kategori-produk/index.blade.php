<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kategori - PasarLocal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-green {
            background-color: #28a745;
        }

        .navbar-green .nav-link,
        .navbar-green .navbar-brand {
            color: white;
        }

        .navbar-green .nav-link.active {
            background-color: #218838;
            color: white;
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        .btn-hijau {
            background-color: #28a745;
            color: white;
        }

        .btn-hijau:hover {
            background-color: #218838;
            color: white;
        }

        .btn-hijau-light {
            background-color: #a6e3b8;
            color: #155724;
        }

        .btn-hijau-light:hover {
            background-color: #90d9a6;
            color: #0c3f1e;
        }

        .btn-hijau-danger {
            background-color: #c82333;
            color: white;
        }

        .btn-hijau-danger:hover {
            background-color: #a71d2a;
            color: white;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-green">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">PasarLocal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manajemen Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('kategori-produk.index') }}">Manajemen Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Manajemen Promosi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Manajemen Pedagang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container py-4">
        <h2 class="mb-4">Manajemen Kategori Produk</h2>

        {{-- Tombol Tambah Kategori --}}
        <div class="mb-3 text-end">
            <a href="{{ route('kategori-produk.create') }}" class="btn btn-hijau">
                + Tambah Kategori
            </a>
        </div>

        {{-- Kartu-kartu Kategori --}}
        <div class="row">
            @forelse($kategori as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($item->gambar)
                        <img src="{{ url('uploads_kategori/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama_kategori }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $item->nama_kategori }}</h5>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('kategori-produk.edit', $item->id) }}" class="btn btn-sm btn-hijau-light w-100 me-1">Edit</a>
                            <form action="{{ route('kategori-produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus kategori ini?')" class="w-100 ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-hijau-danger w-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada kategori produk.</p>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
