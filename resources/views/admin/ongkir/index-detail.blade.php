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
            <h5 class="card-title m-b-0">Detail Ongkir</h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <a href="\admin\tambah-ongkir" class="btn btn-success mb-3">tambah ongkir</a>
                <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nama Pasar</th>
                        <th scope="col">Kecamatan Tujuan</th>
                        <th scope="col">Ongkir</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="customtable">
                    @foreach($pasar as $psr)
                    @foreach($psr->ongkir as $ongkir)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $psr->nama_pasar }}</td>
                        <td>{{ $ongkir->kecamatan_tujuan}}</td>
                        <td>Rp.{{ number_format($ongkir->ongkir,0)}}</td>
                        <td>
                            <a href="{{ route('admin.ongkir.edit', $ongkir->id) }}" class="btn btn-info btn-sm">Edit <span class="bi bi-pencil-square"></span></a>
                            <form action="{{ route('admin.ongkir.destroy', $ongkir->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Remove <span class="bi bi-trash"></span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.ongkir.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</body>
</html>
