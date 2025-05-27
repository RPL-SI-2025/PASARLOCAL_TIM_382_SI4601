<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - PasarLocal</title>
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
        .profile-info {
            font-size: 1.1rem;
        }
        .profile-label {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
@include('admin.partials.navbar')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Profil Saya</h3>
            <a href="{{ $role === 'pedagang' ? route('pedagang.profile.edit') : route('profile.edit') }}" class="btn btn-light">Edit Profil</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Foto Profil" class="profile-image mb-3">
                    @else
                        <div class="profile-image mb-3 d-flex align-items-center justify-content-center bg-light">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="profile-info">
                        @if($role === 'pedagang')
                            <div class="mb-3">
                                <span class="profile-label">Nama Pemilik:</span>
                                <span>{{ $profile->nama_pemilik }}</span>
                            </div>
                            <div class="mb-3">
                                <span class="profile-label">Nama Toko:</span>
                                <span>{{ $profile->nama_toko }}</span>
                            </div>
                        @else
                            <div class="mb-3">
                                <span class="profile-label">Nama Customer:</span>
                                <span>{{ $profile->nama_customer }}</span>
                            </div>
                        @endif
                        <div class="mb-3">
                            <span class="profile-label">Email:</span>
                            <span>{{ $profile->email }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="profile-label">Nomor Telepon:</span>
                            <span>{{ $profile->nomor_telepon }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="profile-label">Alamat:</span>
                            <span>{{ $profile->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html> 