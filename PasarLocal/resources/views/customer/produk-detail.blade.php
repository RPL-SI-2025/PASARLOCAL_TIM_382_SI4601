<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-detail-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            overflow: hidden;
            padding-bottom: 20px; /* Add padding at the bottom */
        }
        .product-image-wrapper {
            width: 100%;
            height: 300px;
            overflow: hidden;
        }
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .content-section {
            padding: 20px;
        }
        .product-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #198754; /* Green color for price */
            margin-bottom: 20px;
        }
        .info-group {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1rem;
            color: #333;
        }
        hr {
            margin: 20px 0;
        }
        .pedagang-info h6 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-left: 20px; /* Align with content padding */
            margin-top: 20px; /* Space from the container */
            background-color: #f0f0f0;
            color: #555;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .btn-back:hover {
            background-color: #e0e0e0;
            color: #333;
        }
    </style>
</head>
<body>
    @include('customer.partials.navbar')

    <div class="container py-4">
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="product-detail-container">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('uploads_produk/' . $produkPedagang->produk->gambar) }}" class="product-image" alt="{{ $produkPedagang->produk->nama_produk }}">
                    </div>
                    <div class="content-section">
                        <h2 class="product-title">{{ $produkPedagang->produk->nama_produk }}</h2>
                        <div class="product-price">Rp {{ number_format($produkPedagang->harga, 0, ',', '.') }}</div>

                        <div class="info-group">
                            <span class="info-label">Stok:</span>
                            <span class="info-value">{{ $produkPedagang->stok }} {{ $produkPedagang->satuan }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Jumlah per Satuan:</span>
                            <span class="info-value">{{ $produkPedagang->jumlah_satuan }} {{ $produkPedagang->satuan }}</span>
                        </div>
                        <div class="info-group">
                            <span class="info-label">Deskripsi:</span>
                            <span class="info-value">{{ $produkPedagang->deskripsi }}</span>
                        </div>

                        <hr>

                        <div class="pedagang-info">
                            <h6>Informasi Pedagang</h6>
                            <div class="info-group">
                                <span class="info-label">Nama Pedagang:</span>
                                <span class="info-value">{{ $produkPedagang->pedagang->nama_pemilik }}</span>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Nama Toko:</span>
                                <span class="info-value">{{ $produkPedagang->pedagang->nama_toko }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 