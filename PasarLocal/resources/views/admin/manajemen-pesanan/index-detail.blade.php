<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan #{{ $order->id }} - PasarLocal</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .btn-hijau {
            background-color: #28a745;
            color: white;
        }
        .btn-hijau:hover {
            background-color: #218838;
            color: white;
        }
        .order-status-badge {
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 5px;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>

    @include('admin.partials.navbar')

    <div class="container py-4">
        <h2>Detail Pesanan #{{ $order->id }}</h2>
        <div class="card shadow-sm mt-3" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Pelanggan: {{ $order->customer->nama_customer }}</h5>
                <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p><strong>Status Bayar:</strong> {{ $order->status }}</p>

                <form action="{{ route('admin.manajemen-pesanan.update', $order->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')

                    <label for="status" class="form-label"><strong>Status Pesanan</strong></label>
                    <select name="status" id="status_pesanan" class="form-select" required>
                        <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Dikirim" {{ $order->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Batal" {{ $order->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                    </select>

                    <button type="submit" class="btn btn-hijau mt-3">Update Status</button>
                </form>

                <a href="{{ route('admin.manajemen-pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
