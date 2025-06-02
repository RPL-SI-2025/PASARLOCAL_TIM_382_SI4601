<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .navbar .brand-logo {
            height: 60px;
            width: auto;
            margin-right: 15px;
            object-fit: contain;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            border: 2px solid #ddd;
        }

        .dropdown-menu .dropdown-item {
            text-align: left !important;
            padding-left: 15px !important;
        }

        .market-card {
            /* ... existing code ... */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo dan Search -->
            <div class="d-flex align-items-center gap-4">
                <!-- Brand logo -->
                <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                    <img src="{{ asset('uploads_logo/PASARLOCALLL.png') }}" alt="PasarLocal" class="brand-logo">
                </a>

                <!-- Toggler for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <!-- Left menu -->
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('pedagang.manajemen_produk.index') }}">
                            Manajemen Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('pedagang.reviews.index') }}">Melihat Review Produk</a>
                    </li>
                </ul>

                <!-- User profile dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 user-profile" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>{{ Auth::user()->nama_pemilik ?? Auth::user()->name }}</span>
                        <div class="user-avatar">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('profil_pedagang/' . Auth::user()->profile_image) }}" alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        {{-- Removed Profile and Settings links as requested --}}
                        {{-- <li><a class="dropdown-item" href="/profile">Profile</a></li> --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i> Edit Profil
                            </a>
                        </li>
                        {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                        {{-- <li><hr class="dropdown-divider"></li> --}}
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main class="main-content">
    @yield('content')
</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
