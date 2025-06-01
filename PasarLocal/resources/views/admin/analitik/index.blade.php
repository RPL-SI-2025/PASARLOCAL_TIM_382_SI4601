<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">Dashboard Analitik</h2>

        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-4 mb-6">
            <input type="date" name="start_date" class="border rounded px-3 py-2" value="{{ $start }}">
            <input type="date" name="end_date" class="border rounded px-3 py-2" value="{{ $end }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('dashboard.export.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
                    class="bg-red-600 text-white px-4 py-2 rounded">Export PDF</a>
                <a href="{{ route('dashboard.export.excel', ['start_date' => $start, 'end_date' => $end]) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded">Export Excel</a>
            </div>
        </form>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h3 class="text-lg font-semibold mb-2">Pendapatan per Produk</h3>
                                <canvas id="revenuePerProduct"></canvas>
                            </div>
                            <div class="carousel-item">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <h3 class="text-lg font-semibold mb-2">Pendapatan per Pedagang</h3>
                                    <canvas id="revenuePerPedagang"></canvas>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <h3 class="text-lg font-semibold mb-2">Pendapatan per Pasar</h3>
                                    <canvas id="revenuePerPasar"></canvas>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <h3 class="text-lg font-semibold mb-2">Segmentasi Customer (Kecamatan)</h3>
                                    <canvas id="customerSegmentation"></canvas>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    <h3 class="text-lg font-semibold mb-2">Customer Online (5 menit terakhir)</h3>
                </div>
                <div class="card-body">
                    <ul id="onlineUsers" class="list-disc pl-5 text-sm text-gray-700"></ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ url('/dashboard/data') }}?start_date={{ $start }}&end_date={{ $end }}")
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    createChart('revenuePerProduct', data.revenuePerProduct.map(r => r.nama_produk), data
                        .revenuePerProduct.map(r => r.total));
                    createChart('revenuePerPedagang', data.revenuePerPedagang.map(r => r.nama_toko), data
                        .revenuePerPedagang.map(r => r.total));
                    createChart('revenuePerPasar', data.revenuePerPasar.map(r => r.nama_pasar), data
                        .revenuePerPasar.map(r => r.total));
                    createChart('customerSegmentation', data.customerSegmentation.map(r => r.kecamatan), data
                        .customerSegmentation.map(r => r.total));

                    const ul = document.getElementById('onlineUsers');
                    data.onlineUsers.forEach(user => {
                        const li = document.createElement('li');
                        li.textContent = `${user.name} (${user.email})`;
                        ul.appendChild(li);
                    });
                });

            function createChart(id, labels, data) {
                const backgroundColors = [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                    '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6',
                    '#eab308', '#f97316', '#a855f7', '#0ea5e9'
                ].slice(0, data.length);

                new Chart(document.getElementById(id), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: data,
                            backgroundColor: backgroundColors.slice(0, data.length)
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            datalabels: {
                                color: function(context) {
                                    // warna label sama dengan warna batang
                                    return backgroundColors[context.dataIndex];
                                },
                                anchor: 'end',
                                align: 'bottom',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }
        });
    </script>
</body>

</html>
