<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Ongkir - PasarLocal</title>
</head>
<body>
@include('admin.partials.navbar')

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Ongkir</h6>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('admin.ongkir.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="pasarSelect" class="form-label">Pilih Pasar</label>
                            <select class="form-select" name="id_pasar" required>
                                <option value="" disabled selected >-- Pilih Pasar --</option>
                                @foreach($pasar as $item)
                                    <option value="{{ $item->id_pasar }}" {{ old('id_pasar') == $item->id_pasar ? 'selected' : '' }}>
                                        {{ $item->nama_pasar }} ({{ $item->id_pasar }})
                                    </option>
                                @endforeach
                            </select>

                            <div class="my-3">
                                <label for="Tujuan" class="form-label">Kecamatan Tujuan</label>
                                <select class="form-select" id="Tujuan" name="kecamatan_tujuan" required dusk='kecamatan'>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach(\App\Constants\Kecamatan::getAll() as $kecamatan)
                                        <option value="{{ $kecamatan }}" {{ old('kecamatan_tujuan') == $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ongkir" class="form-label">Biaya Ongkir (Rp)</label>
                                <input type="number" class="form-control" id="ongkir" name="ongkir" min="0" step="1000" value="{{ old('ongkir') }}" required dusk='Ongkir'>
                                <div class="form-text">Isikan tanpa titik atau koma (contoh: 10000)</div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">


                                <button type="submit" class="btn btn-success" dusk='simpan-ongkir'>
                                    <i class="fas fa-check me-1"></i> Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
