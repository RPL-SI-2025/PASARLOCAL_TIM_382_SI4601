<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PasarLocal') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
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
        .cart-icon {
            font-size: 1.2rem;
            color: #27ae60;
        }
        .cart-badge {
            position: absolute;
            top: 0;
            right: -5px;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            background-color: #dc3545;
            color: white;
            border-radius: 0.25rem;
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
                <img src="{{ asset('PASARLOCALLL.png') }}" alt="Logo" class="navbar-logo">
            </a>
            <div class="navbar-menu d-flex align-items-center flex-grow-1">
                @if(auth()->user()->role === 'pedagang')
                    <a class="nav-link{{ request()->routeIs('pedagang.manajemen_produk') ? ' active' : '' }}" href="{{ route('pedagang.manajemen_produk.index') }}">Manajemen Produk</a>
                    <a class="nav-link{{ request()->routeIs('pedagang.review_produk') ? ' active' : '' }}" href="#">Melihat Review Produk</a>
                @endif
            </div>
            <div class="d-flex align-items-center">
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('cart.index') }}" class="position-relative me-3">
                        <i class="bi bi-cart cart-icon"></i>
                        @if(auth()->user()->customer && auth()->user()->customer->carts()->exists())
                            <span class="cart-badge">{{ auth()->user()->customer->carts->sum(function($cart) { return $cart->items->count(); }) }}</span>
                        @endif
                    </a>
                @endif
                <div class="profile-dropdown">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fw-bold">{{ auth()->user()->name }}</span>
                            <span class="d-none d-md-inline text-muted" style="font-size: 0.9em;">{{ auth()->user()->email }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><strong>{{ auth()->user()->name }}</strong><br><small>{{ auth()->user()->email }}</small></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Lihat Profil</a></li>
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
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>