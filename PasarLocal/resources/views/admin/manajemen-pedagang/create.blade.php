<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pedagang - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 2px; }
        .card { border: 1px solid #28a745; }
        .card-header { background-color: #28a745; color: white; }
        .form-label { color: #495057; }
        .btn-secondary, .btn-success { font-weight: bold; }
    </style>
</head>
<body>
@include('admin.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Pedagang</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.manajemen-pedagang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" id="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                    @error('nama_pemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Password minimal 8 karakter</small>
                </div>

                <div class="mb-3">
                    <label for="nama_toko" class="form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" value="{{ old('nama_toko') }}" required>
                    @error('nama_toko')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                    @error('nomor_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_pasar" class="form-label">Pilih Pasar</label>
                    <select name="id_pasar" class="form-control @error('id_pasar') is-invalid @enderror" id="id_pasar" required>
                        <option value="">Pilih Pasar</option>
                        @foreach($pasar as $p)
                            <option value="{{ $p->id_pasar }}" {{ old('id_pasar') == $p->id_pasar ? 'selected' : '' }}>{{ $p->nama_pasar }}</option>
                        @endforeach
                    </select>
                    @error('id_pasar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.manajemen-pedagang.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 