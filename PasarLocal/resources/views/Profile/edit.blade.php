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
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #28a745;
        }
        .profile-image-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #28a745;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
@include('admin.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Edit Profil</h3>
            <a href="{{ $role === 'pedagang' ? route('pedagang.profile.show') : route('profile.show') }}" class="btn btn-light">Kembali ke Profil</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ $role === 'pedagang' ? route('pedagang.profile.update') : route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($profile->profile_image)
                            <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Foto Profil" class="profile-image-preview" id="preview">
                        @else
                            <div class="profile-image-preview d-flex align-items-center justify-content-center bg-light" id="preview">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Ubah Foto Profil</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if($role === 'pedagang')
                            <div class="mb-3">
                                <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" 
                                    id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $profile->nama_pemilik) }}" required>
                                @error('nama_pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_toko" class="form-label">Nama Toko</label>
                                <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" 
                                    id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $profile->nama_toko) }}" required>
                                @error('nama_toko')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="nama_customer" class="form-label">Nama Customer</label>
                                <input type="text" class="form-control @error('nama_customer') is-invalid @enderror" 
                                    id="nama_customer" name="nama_customer" value="{{ old('nama_customer', $profile->nama_customer) }}" required>
                                @error('nama_customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $profile->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" 
                                id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $profile->nomor_telepon) }}" required>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" name="alamat" rows="3" required>{{ old('alamat', $profile->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="profile-image-preview">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>