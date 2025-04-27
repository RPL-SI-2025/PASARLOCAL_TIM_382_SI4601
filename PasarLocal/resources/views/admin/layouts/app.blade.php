<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PasarLocal Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .btn-hijau {
            background-color: #28a745;
            color: white;
        }
        .btn-hijau:hover {
            background-color: #218838;
            color: white;
        }
        .btn-hijau-light {
            background-color: #a6e3b8;
            color: #155724;
        }
        .btn-hijau-light:hover {
            background-color: #90d9a6;
            color: #0c3f1e;
        }
        .btn-hijau-danger {
            background-color: #c82333;
            color: white;
        }
        .btn-hijau-danger:hover {
            background-color: #a71d2a;
            color: white;
        }
        .sticky-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container py-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 