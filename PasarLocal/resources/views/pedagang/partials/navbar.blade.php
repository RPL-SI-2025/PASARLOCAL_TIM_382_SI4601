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
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 35px !important;
            min-height: 70px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .navbar .brand-logo {
            height: 60px !important;
            width: auto !important;
            max-height: none !important;
            margin-right: 15px;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .navbar.scrolled .brand-logo {
            height: 45px !important;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Brand logo -->
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <img src="{{ asset('uploads_logo/PASARLOCALLL.png') }}" alt="PasarLocal" class="brand-logo">
            </a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <!-- Left menu -->
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ Request::is('pedagang/manajemen_produk*') ? 'active' : '' }}" href="{{ route('pedagang.manajemen_produk.index') }}" style="border: 2px solid #28a745; border-radius: 8px; color: #28a745; padding: 6px 18px;">
                            Manajemen Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Melihat Review Produk</a>
                    </li>
                </ul>

                <!-- User profile dropdown -->
                <div class="dropdown">
                    <div class="d-flex align-items-center user-profile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="ms-2 text-end">
                            <div class="fw-bold">Pedagang</div>
                            <div class="small text-muted">
                                <span class="fw-bold">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
        </script>
        <main class="main-content">
    @yield('content')
</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
