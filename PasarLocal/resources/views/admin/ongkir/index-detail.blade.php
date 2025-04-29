<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>Detail - Ongkir</title>
</head>
<body>
    @include('admin.partials.navbar')
    <div class="container py-4">
        <div class="card-body text-center mb-3">
            <h5 class="card-title m-b-0">Detail Ongkir - {{ $pasar->nama_pasar }}</h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <a href="{{ route('admin.ongkir.create') }}" class="btn btn-success mb-3" dusk="Tambah-ongkir-button">
                    <i class="bi bi-plus-circle"></i> Tambah Ongkir
                </a>
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kecamatan Tujuan</th>
                        <th scope="col">Ongkir</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="customtable">
                    @forelse($pasar->ongkir as $ongkir)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ongkir->kecamatan_tujuan }}</td>
                        <td>Rp.{{ number_format($ongkir->ongkir, 0) }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.ongkir.edit', $ongkir->id) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.ongkir.destroy', $ongkir->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus ongkir ke {{ $ongkir->kecamatan_tujuan }}?')"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2">Belum ada data ongkir untuk pasar ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.ongkir.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pasar
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
