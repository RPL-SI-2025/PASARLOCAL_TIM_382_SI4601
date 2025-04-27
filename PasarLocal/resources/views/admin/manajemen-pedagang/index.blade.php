@extends('admin.layouts.app')

@section('title', 'Manajemen Pedagang')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manajemen Pedagang</h2>

    <div class="search-container mb-4">
        <form action="{{ route('admin.manajemen-pedagang.index') }}" method="GET" class="d-flex">
            <select name="pasar" class="form-control me-2" style="width: 200px;">
                <option value="">Semua Pasar</option>
                @foreach($pasar as $p)
                    <option value="{{ $p->id_pasar }}" {{ request('pasar') == $p->id_pasar ? 'selected' : '' }}>
                        {{ $p->nama_pasar }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama pedagang..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-hijau">Cari</button>
            @if(request('search') || request('pasar'))
                <a href="{{ route('admin.manajemen-pedagang.index') }}" class="btn btn-secondary ms-2">Reset</a>
            @endif
        </form>
    </div>

    <div class="row">
        @forelse($pedagang as $p)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $p->nama_pedagang }}</h5>
                    <p class="card-text">
                        <i class="fas fa-store"></i> {{ $p->pasar->nama_pasar }}<br>
                        <i class="fas fa-map-marker-alt"></i> {{ $p->lokasi_toko }}
                    </p>
                    <div class="btn-group">
                        <a href="{{ route('admin.manajemen-pedagang.edit', $p->id_pedagang) }}" class="btn btn-hijau btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-hijau-light btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id_pedagang }}">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                        <form action="{{ route('admin.manajemen-pedagang.destroy', $p->id_pedagang) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-hijau-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pedagang ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal{{ $p->id_pedagang }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $p->id_pedagang }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $p->id_pedagang }}">Detail Pedagang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pedagang }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="img-fluid rounded" style="max-height: 200px;">
                            @endif
                        </div>
                        <p><strong>Nama Pedagang:</strong> {{ $p->nama_pedagang }}</p>
                        <p><strong>Pasar:</strong> {{ $p->pasar->nama_pasar }}</p>
                        <p><strong>Lokasi Toko:</strong> {{ $p->lokasi_toko }}</p>
                        <p><strong>Deskripsi:</strong> {{ $p->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Tidak ada data pedagang yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pedagang->links() }}
    </div>
</div>

<!-- Floating Action Button -->
<div class="sticky-btn">
    <a href="{{ route('admin.manajemen-pedagang.create') }}" class="btn btn-hijau">
        + Tambah Pedagang
    </a>
</div>
@endsection 