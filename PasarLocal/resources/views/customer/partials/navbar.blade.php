<style>
    .nav-link.active {
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 6px 12px;
        color: #28a745 !important;
        font-weight: bold;
        background-color: #e9f9ef;
    }
    .nav-link {
        color: #333;
        padding: 6px 12px;
        margin: 0 4px;
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        color: #28a745;
    }
    .dropdown-menu {
        border: 1px solid #dee2e6;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .dropdown-item:hover {
        background-color: #e9f9ef;
        color: #28a745;
    }
    .dropdown-item.active {
        background-color: #28a745;
        color: white;
    }
    .admin-profile {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        color: #333;
        text-decoration: none;
    }
    .admin-profile:hover {
        color: #28a745;
    }
    .admin-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #28a745;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        font-weight: bold;
    }
    .navbar-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .navbar-brand img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    .brand-text {
        font-size: 1.5rem;
        font-weight: bold;
        margin-left: 8px;
    }
    .brand-text .pasar {
        color: #28a745;
    }
    .brand-text .local {
        color: #FDC500;
    }
</style>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Logo dan brand text di kiri -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('uploads_logo/logo.png') }}" alt="Logo" class="me-2">
            <span class="brand-text">
                <span class="pasar">Pasar</span><span class="local">Local</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu manajemen di tengah -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/ongkir*') ? 'active' : '' }}" href="{{ route('admin.ongkir.index') }}">Manajemen Ongkir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/manajemen-produk*') ? 'active' : '' }}" href="{{ route('admin.manajemen-produk.index') }}">Manajemen Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/kategori-produk*') ? 'active' : '' }}" href="{{ route('admin.kategori-produk.index') }}">Manajemen Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/promosi*') ? 'active' : '' }}" href="#">Manajemen Promosi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/manajemen-pasar*') ? 'active' : '' }}" href="{{ route('admin.manajemen-pasar.index') }}">Manajemen Pasar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/manajemen-pedagang*') ? 'active' : '' }}" href="{{ route('admin.manajemen-pedagang.index') }}">Manajemen Pedagang</a>
                </li>
            </ul>

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
</nav>

<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
