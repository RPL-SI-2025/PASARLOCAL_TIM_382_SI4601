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
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $p->nama_toko}}</h5>
                    <div class="mb-1">
                        <i class="fas fa-store"></i> {{ $p->pasar->nama_pasar }}
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt"></i> {{ $p->alamat }}
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{ route('admin.manajemen-pedagang.edit', $p->id_pedagang) }}" class="btn btn-sm btn-hijau-light w-100 me-1">Edit</a>
                            <form action="{{ route('admin.manajemen-pedagang.destroy', $p->id_pedagang) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pedagang ini?')" class="w-100 ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-hijau-danger w-100">Hapus</button>
                            </form>
                        </div>
                        <button type="button" class="btn btn-sm btn-info w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id_pedagang }}">
                            Lihat Detail
                        </button>
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
                        <p><strong>Nama Pemilik:</strong> {{ $p->nama_pemilik }}</p>
                        <p><strong>Nama Toko:</strong> {{ $p->nama_toko }}</p>
                        <p><strong>Pasar:</strong> {{ $p->pasar->nama_pasar }}</p>
                        <p><strong>Alamat:</strong> <i class="fas fa-map-marker-alt"></i> {{ $p->alamat }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $p->nomor_telepon }}</p>
                        <p><strong>Email:</strong> {{ $p->email }}</p>
                        <p><strong>Password:</strong> {{ $p->password }}</p>
                        <p><strong>Dibuat Pada:</strong> {{ $p->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Terakhir Diperbarui:</strong> {{ $p->updated_at->format('d/m/Y H:i') }}</p>
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