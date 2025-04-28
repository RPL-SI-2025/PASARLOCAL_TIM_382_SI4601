<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ongkir - PasarLocal</title>
</head>
<body>
    @include('admin.partials.navbar')
    <div class="container py-4">
        <div class="card-body text-center mb-3">
            <h2 class="card-title m-b-0">Daftar Ongkir</h2>
        </div>
        @foreach ($pasar as $item)
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('uploads_pasar/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama_pasar }}">
                <div class="card-body">
                <h5 class="card-title">
                    {{$item->nama_pasar}}
                </h5>
                <p class="card-text">
                    {{$item->deskripsi}}
                </p>
                <a href="\admin\detail-ongkir" class="btn btn-primary">Lihat Ongkir</a>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
