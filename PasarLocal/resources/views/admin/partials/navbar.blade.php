<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        display: flex;
    }

    .sidebar {
        width: 250px;
        min-height: 100vh;
        background-color: #ffffff;
        border-right: 1px solid #dee2e6;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.05);
        padding: 1rem;
        transition: all 0.3s ease;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .toggle-btn {
        position: absolute;
        top: 1rem;
        right: -15px;
        background-color: #28a745;
        color: #fff;
        border-radius: 0;
        padding: 6px 8px;
        cursor: pointer;
        z-index: 1100;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .brand {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .brand img {
        width: 40px;
        height: 40px;
        transition: width 0.3s ease, height 0.3s ease;
    }

    .sidebar.collapsed .brand img {
        width: 40px; /* tetap ukuran logo */
        height: 40px;
    }

    .brand-text {
        font-size: 1.4rem;
        font-weight: bold;
        margin-left: 10px;
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .sidebar.collapsed .brand-text {
        display: none;
    }

    .brand-text .pasar {
        color: #28a745;
    }

    .brand-text .local {
        color: #FDC500;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        color: #333;
        text-decoration: none;
        margin-bottom: 10px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .nav-link i {
        margin-right: 10px;
        min-width: 18px; /* agar ikon tidak bergeser */
        text-align: center;
    }

    .nav-link:hover {
        background-color: #f1fdf5;
        color: #28a745;
    }

    .nav-link.active {
        background-color: #e9f9ef;
        border: 2px solid #28a745;
        color: #28a745;
        font-weight: bold;
    }

    .sidebar.collapsed .nav-link span {
        display: none;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
    }

    .admin-section {
        position: absolute;
        bottom: 20px;
        width: 100%;
        left: 0;
        padding: 0 1rem;
    }

    .admin-profile {
        display: flex;
        align-items: center;
        color: #333;
        text-decoration: none;
        padding: 8px 0;
        white-space: nowrap;
        overflow: hidden;
        transition: justify-content 0.3s ease;
    }

    .admin-avatar {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        border-radius: 100%;
        background-color: #28a745;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 0.5rem;
        transition: none;
        font-size: 1rem;
    }

    .sidebar.collapsed .admin-profile span {
        display: none;
    }

    .sidebar.collapsed .admin-profile {
        justify-content: center;
        padding-left: 0.5rem;
    }

    .dropdown-menu {
        font-size: 0.9rem;
    }
</style>

<!-- Sidebar -->
<div id="sidebar" class="sidebar collapsed">
    <!-- Toggle Button -->
    <div class="toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
        <i id="toggle-icon" class="fas fa-angle-left"></i>
    </div>

    <!-- Logo & Brand -->
    <div class="brand">
        <img src="{{ asset('uploads_logo/logo.png') }}" alt="Logo">
        <span class="brand-text">
            <span class="pasar">Pasar</span><span class="local">Local</span>
        </span>
    </div>

    <!-- Navigasi -->

    </a>
    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
    <i class="fas fa-home"></i> <span>Homepage</span>
    </a>
    <a class="nav-link {{ request()->is('admin/manajemen-produk*') ? 'active' : '' }}" href="{{ route('admin.manajemen-produk.index') }}">
        <i class="fas fa-box"></i> <span>Manajemen Produk</span>
    </a>
    <a class="nav-link {{ request()->is('admin/kategori-produk*') ? 'active' : '' }}" href="{{ route('admin.kategori-produk.index') }}">
        <i class="fas fa-tags"></i> <span>Manajemen Kategori</span>
    </a>
    <a class="nav-link {{ request()->is('admin/diskons*') ? 'active' : '' }}" href="{{ route('diskons.index') }}">
        <i class="fas fa-bullhorn"></i> <span>Manajemen Diskon</span>
    </a>
    <a class="nav-link {{ request()->is('admin/ongkir*') ? 'active' : '' }}" href="{{ route('admin.ongkir.index') }}">
        <i class="fas fa-shipping-fast"></i> <span>Manajemen Ongkir</span>
    </a>
    <a class="nav-link {{ request()->is('admin/manajemen-pasar*') ? 'active' : '' }}" href="{{ route('admin.manajemen-pasar.index') }}">
        <i class="fas fa-store"></i> <span>Manajemen Pasar</span>
    </a>
    <a class="nav-link {{ request()->is('admin/manajemen-pedagang*') ? 'active' : '' }}" href="{{ route('admin.manajemen-pedagang.index') }}">
        <i class="fas fa-users"></i> <span>Manajemen Pedagang</span>
    </a>
    <a class="nav-link {{ request()->is('admin/manajemen-pesanan*') ? 'active' : '' }}" href="{{ route('admin.manajemen-pesanan.index') }}">
        <i class="fas fa-receipt"></i> <span>Manajemen Pesanan</span>
    </a>
    <a class="nav-link {{ request()->is('/dashboard/analytic*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="fa-solid fa-chart-simple"></i> <span>Dashboard Analytic</span>
    </a>


    <!-- Admin Info -->
    <div class="admin-section">
        <a href="#" class="admin-profile dropdown-toggle" data-bs-toggle="dropdown">
            <div class="admin-avatar"><i class="fas fa-user"></i></div>
            <span>Admin</span>
        </a>
        <ul class="dropdown-menu">
            <li class="px-3 pt-2 pb-0">
                <small class="text-muted">Signed in as</small><br>
                <span class="fw-bold">{{  auth()->user()->email}}</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- JavaScript untuk toggle -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const icon = document.getElementById('toggle-icon');
        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            icon.classList.remove('fa-angle-left');
            icon.classList.add('fa-angle-right');
        } else {
            icon.classList.remove('fa-angle-right');
            icon.classList.add('fa-angle-left');
        }
    }
</script>
