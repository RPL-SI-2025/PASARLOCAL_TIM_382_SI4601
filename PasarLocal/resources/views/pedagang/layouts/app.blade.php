<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PasarLocal') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fa;
        }
        .navbar-custom {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 1030;
            padding: 0.5rem 0;
        }
        .navbar-logo {
            height: 38px;
            margin-right: 16px;
        }
        .navbar-menu {
            margin-right: 24px;
        }
        .navbar-menu .nav-link.active {
            border: 2px solid #27ae60;
            border-radius: 8px;
            color: #27ae60 !important;
            background: #eafaf1;
        }
        .navbar-menu .nav-link {
            color: #222 !important;
            font-weight: 500;
            margin-right: 8px;
        }
        .profile-dropdown .dropdown-toggle {
            color: #222;
            font-weight: 600;
        }
        .profile-dropdown .dropdown-menu {
            min-width: 220px;
        }
        .profile-dropdown .dropdown-item small {
            color: #888;
        }
        .main-content {
            margin-top: 32px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('PASARLOCALLL.png') }}" alt="Logo PasarLocal" class="navbar-logo">
        </a>
        <div class="profile-dropdown ms-auto">
            <div class="dropdown">
                <!-- Profile dan logout di kanan -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="admin-avatar">A</div>
                            <span>{{ Auth::user()->role }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-header">
                                    <small class="text-muted">Signed in as</small><br>
                                    <span class="fw-bold">{{ Auth::user()->email }}</span>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
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
