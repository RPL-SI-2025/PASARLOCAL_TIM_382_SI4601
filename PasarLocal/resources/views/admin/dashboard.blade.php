<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - PasarLocal</title>
    <!-- Tambahkan link CSS Bootstrap atau custom CSS di sini -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
    @include('admin.partials.navbar')
    <div class="container px-4 mt-4">
        <h1>Homepage Admin</h1>
        <p>Selamat datang di halaman Admin PasarLocal!</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h5>Jumlah Produk</h5>
                        <h2>{{ $jumlahProduk }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <h5>Jumlah Pedagang</h5>
                        <h2>{{ $jumlahPedagang }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                        <h5>Jumlah Pasar</h5>
                        <h2>{{ $jumlahPasar }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <h5>Jumlah Kategori</h5>
                        <h2>{{ $jumlahKategori }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Menu Navigasi Admin -->
            <div class="col-md-3">
                <a href="{{ route('admin.manajemen-produk.index') }}" class="text-decoration-none">
                    <div class="card border-success shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-box fa-2x text-success mb-2"></i>
                            <h6>Manajemen Produk</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.kategori-produk.index') }}" class="text-decoration-none">
                    <div class="card border-warning shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-tags fa-2x text-warning mb-2"></i>
                            <h6>Manajemen Kategori</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('diskons.index') }}" class="text-decoration-none">
                    <div class="card border-danger shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-bullhorn fa-2x text-danger mb-2"></i>
                            <h6>Manajemen Diskon</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.ongkir.index') }}" class="text-decoration-none">
                    <div class="card border-primary shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                            <h6>Manajemen Ongkir</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mt-3">
                <a href="{{ route('admin.manajemen-pasar.index') }}" class="text-decoration-none">
                    <div class="card border-dark shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-store fa-2x text-dark mb-2"></i>
                            <h6>Manajemen Pasar</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mt-3">
                <a href="{{ route('admin.manajemen-pedagang.index') }}" class="text-decoration-none">
                    <div class="card border-secondary shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x text-secondary mb-2"></i>
                            <h6>Manajemen Pedagang</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mt-3">
                <a href="{{ route('admin.manajemen-pesanan.index') }}" class="text-decoration-none">
                    <div class="card border-info shadow h-100 py-2 text-center">
                        <div class="card-body">
                            <i class="fas fa-receipt fa-2x text-info mb-2"></i>
                            <h6>Manajemen Pesanan</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Optional: script Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
