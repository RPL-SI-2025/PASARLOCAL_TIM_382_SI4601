@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Diskon</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                            <i class="fas fa-plus"></i> Tambah Diskon
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Diskon</th>
                                    <th>Nama Diskon</th>
                                    <th>Jenis</th>
                                    <th>Min. Pembelian</th>
                                    <th>Status</th>
                                    <th>Periode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diskons as $diskon)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    // Determine status based on dates only
                                    if ($now->lt($diskon->tanggal_mulai)) {
                                        $statusClass = 'bg-warning';
                                        $statusText = 'Belum Aktif';
                                    } elseif ($now->gt($diskon->tanggal_berakhir)) {
                                        $statusClass = 'bg-secondary';
                                        $statusText = 'Kadaluarsa';
                                    } else {
                                        $statusClass = 'bg-success';
                                        $statusText = 'Aktif';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $diskon->kode_diskon }}</td>
                                    <td>{{ $diskon->nama_diskon }}</td>
                                    <td>{{ ucfirst($diskon->jenis_diskon) }}</td>
                                    <td>{{ $diskon->min_pembelian ? number_format($diskon->min_pembelian, 0, ',', '.') : '-' }}</td>
                                    <td>
                                        <span class="badge {{ $statusClass }} text-white">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $diskon->tanggal_mulai->format('d/m/Y') }} - 
                                        {{ $diskon->tanggal_berakhir->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $diskon->id_diskon }}" title="Edit Diskon">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $diskon->id_diskon }}" title="Hapus Diskon">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada diskon</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $diskons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('diskons.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-create-label">Tambah Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="nama_diskon">Nama Diskon</label>
                        <input type="text" class="form-control" id="nama_diskon" name="nama_diskon" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jenis_diskon">Jenis Diskon</label>
                        <select class="form-control" id="jenis_diskon" name="jenis_diskon" required>
                            <option value="amount">Potongan Harga</option>
                            <option value="shipping">Gratis Ongkir</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="max_diskon">Maksimal Diskon</label>
                        <input type="number" class="form-control" id="max_diskon" name="max_diskon" min="0">
                    </div>
                    <div class="form-group mb-2">
                        <label for="min_pembelian">Minimal Pembelian</label>
                        <input type="number" class="form-control" id="min_pembelian" name="min_pembelian" min="0">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tanggal_berakhir">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($diskons as $diskon)
<div class="modal fade" id="modal-edit-{{ $diskon->id_diskon }}" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label-{{ $diskon->id_diskon }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('diskons.update', $diskon->id_diskon) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-label-{{ $diskon->id_diskon }}">Edit Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="nama_diskon">Nama Diskon</label>
                        <input type="text" class="form-control" id="nama_diskon" name="nama_diskon" value="{{ $diskon->nama_diskon }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $diskon->deskripsi }}</textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jenis_diskon">Jenis Diskon</label>
                        <select class="form-control" id="jenis_diskon" name="jenis_diskon" required>
                            <option value="amount" {{ $diskon->jenis_diskon == 'amount' ? 'selected' : '' }}>Potongan Harga</option>
                            <option value="shipping" {{ $diskon->jenis_diskon == 'shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="max_diskon">Maksimal Diskon</label>
                        <input type="number" class="form-control" id="max_diskon" name="max_diskon" value="{{ $diskon->max_diskon }}" min="0">
                    </div>
                    <div class="form-group mb-2">
                        <label for="min_pembelian">Minimal Pembelian</label>
                        <input type="number" class="form-control" id="min_pembelian" name="min_pembelian" value="{{ $diskon->min_pembelian }}" min="0">
                    </div>
                    <div class="form-group mb-2">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $diskon->tanggal_mulai->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tanggal_berakhir">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ $diskon->tanggal_berakhir->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal-delete-{{ $diskon->id_diskon }}" tabindex="-1" role="dialog" aria-labelledby="modal-delete-label-{{ $diskon->id_diskon }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('diskons.destroy', $diskon->id_diskon) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-delete-label-{{ $diskon->id_diskon }}">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus diskon "{{ $diskon->nama_diskon }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
// Fungsi toggleStatus tidak lagi digunakan karena aksi status dihapus
// function toggleStatus(id) {
//     if (confirm('Apakah Anda yakin ingin mengubah status diskon ini?')) {
//         fetch(`/diskons/${id}/toggle-status`, {
//             method: 'PATCH',
//             headers: {
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                 'Accept': 'application/json',
//                 'Content-Type': 'application/json'
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.status === 'success') {
//                 // Find the table row for this diskon ID
//                 const row = document.querySelector(`button[onclick='toggleStatus(${id})']`).closest('tr');
//                 const statusBadge = row.querySelector('span.badge');

//                 // Get the updated diskon object from the backend response
//                 const updatedDiskon = data.diskon;

//                 // Determine the new status text and class based on the updated status and dates
//                 let newStatusText, newStatusClass;
//                 const now = new Date();
//                 const tanggalMulai = new Date(updatedDiskon.tanggal_mulai);
//                 const tanggalBerakhir = new Date(updatedDiskon.tanggal_berakhir);

//                 if (!updatedDiskon.aktif) {
//                     newStatusText = 'Nonaktif';
//                     newStatusClass = 'bg-danger';
//                 } else if (now < tanggalMulai) {
//                     newStatusText = 'Belum Aktif';
//                     newStatusClass = 'bg-warning';
//                 } else if (now > tanggalBerakhir) {
//                     newStatusText = 'Kadaluarsa';
//                     newStatusClass = 'bg-secondary';
//                 } else {
//                     newStatusText = 'Aktif';
//                     newStatusClass = 'bg-success';
//                 }

//                 // Update the status badge
//                 statusBadge.textContent = newStatusText;
//                 statusBadge.className = `badge ${newStatusClass} text-white`;
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert('Terjadi kesalahan saat mengubah status diskon.');
//         });
//     }
// }
</script>
@endpush 