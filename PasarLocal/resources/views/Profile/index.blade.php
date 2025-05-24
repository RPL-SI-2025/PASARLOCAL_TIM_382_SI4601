<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            border: 1px solid #28a745;
        }
        .card-header {
            background-color: #28a745;
            color: white;
        }
        .form-label {
            color: #495057;
        }
        .btn-secondary, .btn-success {
            font-weight: bold;
        }
    </style>
</head>
<body>
@auth
    <div class="dropdown">
        <div class="d-flex align-items-center" data-bs-toggle="dropdown">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <div class="small text-muted">{{ Auth::user()->email }}</div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            @if (Auth::user()->role === 'pedagang')
                @include('pedagang.partials.navbar')
            @elseif (Auth::user()->role === 'customer')
                @include('customer.partials.navbar')
            @endif
        </ul>
    </div>
@endauth
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Profil</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror"
                           value="{{ old('nomor_telepon', auth()->user()->nomor_telepon) }}">
                    @error('nomor_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                           value="{{ old('alamat', auth()->user()->alamat) }}">
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Foto Profil (opsional)</label>
                    <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                    @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    @if(auth()->user()->profile_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Foto Profil" width="120" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Perbarui Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
