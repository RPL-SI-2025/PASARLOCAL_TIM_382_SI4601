<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Ongkir | PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-input {
            border: 2px solid #4CAF50;
            border-radius: 10px;
            padding: 10px;
        }
        .btn-cek {
            background-color: red;
            color: white;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: bold;
        }
        .hasil-box {
            background: #f1f3f5;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body class="container mt-5">

    <h1 class="text-center mb-3 text-success fw-bold">Cek Ongkir</h1>
    <p class="text-center mb-5 text-muted">Cek Tarif Kirimanmu</p>

    <form action="{{ route('cek-ongkir.submit') }}" method="POST" class="text-center">
        @csrf
        <div class="mb-3">
            <input type="text" name="lokasi_awal" class="form-control custom-input" placeholder="Lokasi kamu" value="{{ old('lokasi_awal') }}">
        </div>
        <div class="mb-3">
            <input type="text" name="lokasi_tujuan" class="form-control custom-input" placeholder="Pasar Tujuan" value="{{ old('lokasi_tujuan') }}">
        </div>
        <button type="submit" class="btn btn-cek">Lihat Harga</button>
    </form>

    @if(isset($dari) && isset($tujuan) && isset($biaya))
    <div class="hasil-box">
        <p><strong>Dari</strong> : {{ $dari }}</p>
        <p><strong>Tujuan</strong> : {{ $tujuan }}</p>
        <p><strong>Biaya</strong> : Rp {{ number_format($biaya, 0, ',', '.') }}</p>
    </div>
    @endif

</body>
</html>
