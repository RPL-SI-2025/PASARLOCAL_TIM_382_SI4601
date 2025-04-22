<style>
    .nav-link.active {
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 6px 12px;
        color: #28a745 !important;
        font-weight: bold;
        background-color: #e9f9ef;
    }
</style>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('uploads_logo/logo.png') }}" alt="Logo" width="40" class="me-2">
            <span class="fw-bold" style="color: #28a745;">Pasar<span style="color: #f7c600;">Local</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
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
                    <a class="nav-link {{ request()->is('admin/pasar*') ? 'active' : '' }}" href="{{ route('admin.pasar.index') }}">Manajemen Pasar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/pedagang*') ? 'active' : '' }}" href="#">Manajemen Pedagang</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
