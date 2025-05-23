<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ongkir - PasarLocal</title>
    <style>
.card-img-top {
    object-fit: cover;
    height: 200px;
}
</style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container py-4">
        <div class="text-center mb-4">
            <h2>Daftar Ongkir</h2>
        </div>

        <div class="row">
            @foreach ($pasar as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('uploads_pasar/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama_pasar }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->nama_pasar }}</h5>
                        <p class="card-text">{{ $item->lokasi }}</p>
                        <a href="{{ url('detail-ongkir/' . $item->id_pasar) }}" class="btn btn-primary mt-auto" dusk="lihat-ongkir-button">
                            Lihat Ongkir
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>
