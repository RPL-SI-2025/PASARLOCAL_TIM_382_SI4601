<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pasar - PasarLocal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
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

        /* Style untuk modal detail */
        .modal-content {
            background-color: white;
            color: #333;
        }

        .modal-header {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body {
            background-color: white;
            padding: 20px;
        }

        .modal-footer {
            background-color: white;
            border-top: 1px solid #dee2e6;
        }

        .detail-btn {
            background-color: #17a2b8;
            color: white;
        }

        .detail-btn:hover {
            background-color: #138496;
            color: white;
        }

        .search-result-info {
            margin-bottom: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container py-4">
        <h2 class="mb-4">Manajemen Pasar</h2>

        <div class="search-container">
            <form action="{{ route('admin.pasar.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari pasar..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-hijau">Cari</button>
                @if($search)
                    <a href="{{ route('admin.pasar.index') }}" class="btn btn-secondary ms-2">Reset</a>
                @endif
            </form>
        </div>

        <br>

        @if($search)
            <div class="search-result-info">
                @if($pasar->count() > 0)
                    <p>Menampilkan {{ $pasar->count() }} hasil pencarian untuk "{{ $search }}"</p>
                @else
                    <p>Tidak ditemukan hasil untuk pencarian "{{ $search }}"</p>
                @endif
            </div>
        @endif

        <div class="row">
            @forelse($pasar as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($item->gambar)
                    <img src="{{ url('uploads_pasar/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama_pasar }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $item->nama_pasar }}</h5>
                        <p class="text-center">{{ $item->lokasi }}</p>
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('admin.pasar.edit', $item->id_pasar) }}" class="btn btn-sm btn-hijau-light w-100 me-1">Edit</a>
                            <form action="{{ route('admin.pasar.destroy', $item->id_pasar) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pasar ini?')" class="w-100 ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-hijau-danger w-100">Hapus</button>
                            </form>
                        </div>

                        <button type="button" class="btn btn-sm detail-btn mt-2 w-100" data-bs-toggle="modal" data-bs-target="#pasarModal{{ $item->id_pasar }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="pasarModal{{ $item->id_pasar }}" tabindex="-1" aria-labelledby="pasarModalLabel{{ $item->id_pasar }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pasarModalLabel{{ $item->id_pasar }}">{{ $item->nama_pasar }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($item->gambar)
                                        <img src="{{ asset('uploads_pasar/' . $item->gambar) }}" class="img-fluid rounded mb-3" alt="{{ $item->nama_pasar }}">
                                    @else
                                        <img src="https://via.placeholder.com/500x300?text=No+Image" class="img-fluid rounded mb-3" alt="No Image">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Informasi Pasar</h6>
                                    <p><strong>ID Pasar:</strong> {{ $item->id_pasar }}</p>
                                    <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $item->deskripsi ?? 'Deskripsi belum tersedia.' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">{{ $search ? 'Tidak ditemukan pasar yang sesuai dengan pencarian.' : 'Belum ada pasar.' }}</p>
            </div>
            @endforelse
        </div>

        <div class="sticky-btn">
            <a href="{{ route('admin.pasar.create') }}" class="btn btn-hijau">
                + Tambah Pasar
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 