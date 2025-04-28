<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk - PasarLocal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .sticky-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container py-4">
        <h2 class="mb-4">Manajemen Produk</h2>

        <div class="mb-3">
            <form action="{{ route('admin.manajemen-produk.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request()->query('search') }}">

                <select name="kategori" class="form-control me-2">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request()->query('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-hijau">Cari</button>
            </form>
        </div>

        <div class="row">
            @forelse($produk as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($item->gambar)
                    <img src="{{ url('uploads_produk/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama_produk }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $item->nama_produk }}</h5>
                        <p class="text-center">{{ $item->kategori->nama_kategori }}</p>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('admin.manajemen-produk.edit', $item->id) }}" class="btn btn-sm btn-hijau-light w-100 me-1">Edit</a>
                            <form action="{{ route('admin.manajemen-produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus produk ini?')" class="w-100 ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-hijau-danger w-100">Hapus</button>
                            </form>
                        </div>

                        <button type="button" class="btn btn-sm btn-info mt-2 w-100">
                            <a href="{{ route('admin.manajemen-produk.show', $item->id) }}" class="text-white text-decoration-none">Lihat Detail</a>
                        </button>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="produkModal{{ $item->id }}" tabindex="-1" aria-labelledby="produkModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="produkModalLabel{{ $item->id }}">{{ $item->nama_produk }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Kategori:</strong> {{ $item->kategori->nama_kategori }}</p>
                            <p><strong>Deskripsi:</strong> {{ $item->deskripsi ?? 'Deskripsi belum tersedia.' }}</p>
                            <div>
                                @if($item->gambar)
                                    <img src="{{ asset('uploads_produk/' . $item->foto) }}" class="img-fluid" alt="{{ $item->nama_produk }}">
                                @else
                                    <img src="https://via.placeholder.com/500x300?text=No+Image" class="img-fluid" alt="No Image">
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada data produk yang ditemukan.
                </div>
            </div>
            @endforelse
        </div>

        <div class="sticky-btn">
            <a href="{{ route('admin.manajemen-produk.create') }}" class="btn btn-hijau">
                + Tambah Produk
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
