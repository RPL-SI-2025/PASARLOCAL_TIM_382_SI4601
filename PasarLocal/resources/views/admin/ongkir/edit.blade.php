<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .card {
            border-radius: 10px;
        }
        .form-control:disabled {
            background-color: #f8f9fa;
        }
    </style>
    <title>Document</title>
</head>
<body>
    @include('admin.partials.navbar')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Data Ongkir</h6>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.ongkir.update', $ongkir->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pasar_id">Pasar</label>
                                        <select class="form-control" id="pasar_id" name="pasar_id" disabled>
                                            <option value="{{ $ongkir->pasar->id }}">{{ $ongkir->pasar->nama_pasar }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan_tujuan">Kecamatan Tujuan</label>
                                        <select class="form-select @error('kecamatan_tujuan') is-invalid @enderror" id="kecamatan_tujuan" name="kecamatan_tujuan" required dusk="update-tujuan">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach(\App\Constants\Kecamatan::getAll() as $kecamatan)
                                                <option value="{{ $kecamatan }}" {{ old('kecamatan_tujuan', $ongkir->kecamatan_tujuan) == $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
                                            @endforeach
                                        </select>
                                        @error('kecamatan_tujuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ongkir">Biaya Ongkir (Rp)</label>
                                        <input type="number" class="form-control @error('ongkir') is-invalid @enderror"
                                               id="ongkir" name="ongkir"
                                               min="0" step="1000"
                                               value="{{ old('ongkir', $ongkir->ongkir) }}" required dusk="update-ongkir">
                                               <div class="form-text">Isikan tanpa titik atau koma (contoh: 10000)</div>
                                        @error('ongkir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
