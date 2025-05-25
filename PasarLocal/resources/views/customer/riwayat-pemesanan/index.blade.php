<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    @include('customer.partials.navbar')
    <div class="shadow-sm p-3 mb-5 bg-body rounded">
        <div class="container py-4">
            <div class="container-fluid">
                <p class="h4">Riwayat Pemesanan</p>
                <table class="table">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Cari Transaksimu di sini">
                    </div>
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
    <div style="position: relative; width: 200px; height: 100px; overflow: hidden;">
        <!-- Lingkaran abu-abu -->
        <div style="width: 200px; height: 200px; border-radius: 50%; background: #e9ecef;"></div>

        <!-- Lingkaran nilai -->
        <div style="
            position: absolute;
            top: 0;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            clip-path: inset(0 50% 0 0);
            background: #28a745;
            transform: rotate(126deg); /* atur sesuai nilai */
        "></div>

        <!-- Penunjuk tengah -->
        <div style="
            position: absolute;
            top: 50%;
            left: 50%;
            width: 4px;
            height: 50px;
            background: black;
            transform-origin: bottom center;
            transform: rotate(126deg) translate(-50%, -100%);
        "></div>
    </div>
</div>
<p class="text-center mt-2">63%</p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
