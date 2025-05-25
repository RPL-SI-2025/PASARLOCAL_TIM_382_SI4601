<!DOCTYPE html>
<html lang="en">
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
@include('customer.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header">
        <h3 id="edit-profile-title">Edit Profil</h3>

        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">


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
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', auth()->user()->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address', auth()->user()->address) }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Perbarui Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
