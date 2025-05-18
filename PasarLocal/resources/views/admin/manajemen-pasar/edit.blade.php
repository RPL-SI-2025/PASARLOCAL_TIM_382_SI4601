<!DOCTYPE html>
<html>
<head>
    <title>Edit Pasar - PasarLocal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Edit Pasar</h3>
                            <a href="{{ route('admin.manajemen-pasar.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.manajemen-pasar.update', $pasar->id_pasar) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="nama_pasar">Nama Pasar</label>
                                <input type="text" 
                                       class="form-control @error('nama_pasar') is-invalid @enderror" 
                                       id="nama_pasar" 
                                       name="nama_pasar" 
                                       value="{{ old('nama_pasar', $pasar->nama_pasar) }}" 
                                       required>
                                @error('nama_pasar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          required>{{ old('alamat', $pasar->alamat) }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="4" 
                                          required>{{ old('deskripsi', $pasar->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="gambar">Gambar Pasar</label>
                                @if($pasar->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('uploads_pasar/' . $pasar->gambar) }}" 
                                             alt="{{ $pasar->nama_pasar }}" 
                                             style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control @error('gambar') is-invalid @enderror" 
                                       id="gambar" 
                                       name="gambar">
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF (Max. 2MB)</small>
                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 