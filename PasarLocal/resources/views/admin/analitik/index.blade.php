<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Dashboard Analitik</title>
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
                                <div id="noDataProduct" class="text-center text-sm text-gray-500 hidden">Tidak ada data produk</div>
                            </div>
                            <div class="carousel-item">
                                <h3 class="text-lg font-semibold mb-2">Pendapatan per Pedagang</h3>
                                <canvas id="revenuePerPedagang"></canvas>
                                <div id="noDataPedagang" class="text-center text-sm text-gray-500 hidden">Tidak ada data pedagang</div>
                            </div>
                            <div class="carousel-item">
                                <h3 class="text-lg font-semibold mb-2">Pendapatan per Pasar</h3>
                                <canvas id="revenuePerPasar"></canvas>
                                <div id="noDataPasar" class="text-center text-sm text-gray-500 hidden">Tidak ada data pasar</div>
                            </div>
                            <div class="carousel-item">
                                <h3 class="text-lg font-semibold mb-2">Segmentasi Customer (Kecamatan)</h3>
                                <canvas id="customerSegmentation"></canvas>
                                <div id="noDataSegment" class="text-center text-sm text-gray-500 hidden">Tidak ada data segmentasi</div>
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
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-2">Tren Pendapatan Harian</h3>
                    <canvas id="dailyRevenueChart"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-2">Metode Pembayaran</h3>
                    <canvas id="paymentMethodsChart"></canvas>
                    <div id="noDataPayment" class="text-center text-sm text-gray-500 hidden">Tidak ada data metode pembayaran</div>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ url('/dashboard/analytic/data') }}?start_date={{ $start }}&end_date={{ $end }}")
                .then(res => res.json())
                .then(data => {
                    console.log(data);

                    toggleChart('revenuePerProduct', 'noDataProduct',
                        data.revenuePerProduct.map(r => r.nama_produk),
                        data.revenuePerProduct.map(r => r.total));

                    toggleChart('revenuePerPedagang', 'noDataPedagang',
                        data.revenuePerPedagang.map(r => r.nama_toko),
                        data.revenuePerPedagang.map(r => r.total));

                    toggleChart('revenuePerPasar', 'noDataPasar',
                        data.revenuePerPasar.map(r => r.nama_pasar),
                        data.revenuePerPasar.map(r => r.total));

                    toggleChart('customerSegmentation', 'noDataSegment',
                        data.customerSegmentation.map(r => r.kecamatan),
                        data.customerSegmentation.map(r => r.total));

                    createLineChart('dailyRevenueChart',
                        data.dailyRevenue.map(r => r.tanggal),
                        data.dailyRevenue.map(r => r.total));
                    togglePieChart('paymentMethodsChart', 'noDataPayment',
                        data.paymentMethodUsage.map(r => r.metode_pembayaran),
                        data.paymentMethodUsage.map(r => r.total));

                    // Handle online users
                    const ul = document.getElementById('onlineUsers');
                    ul.innerHTML = '';

                    if (data.onlineUsers.length === 0) {
                        const li = document.createElement('li');
                        li.textContent = 'Tidak ada customer online saat ini.';
                        li.classList.add('text-muted');
                        ul.appendChild(li);
                    } else {
                        data.onlineUsers.forEach(user => {
                            const li = document.createElement('li');
                            li.textContent = `${user.name} (${user.email})`;
                            ul.appendChild(li);
                        });
                    }
                });

            function toggleChart(id, noDataId, labels, data) {
                const canvas = document.getElementById(id);
                const noDataDiv = document.getElementById(noDataId);

                if (!labels.length || !data.length) {
                    canvas.style.display = "none";
                    noDataDiv.classList.remove("hidden");
                    return;
                }

                canvas.style.display = "block";
                noDataDiv.classList.add("hidden");

                const backgroundColors = [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                    '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6',
                    '#eab308', '#f97316', '#a855f7', '#0ea5e9'
                ].slice(0, data.length);

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: data,
                            backgroundColor: backgroundColors
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
                                color: (context) => backgroundColors[context.dataIndex],
                                anchor: 'end',
                                align: 'bottom',
                                font: { weight: 'bold' }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }

            function createLineChart(id, labels, data) {
                new Chart(document.getElementById(id), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan Harian',
                            data: data,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // Format ke ribuan / jutaan misal
                                    callback: function(value) {
                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                }
                            }
                        }
                    }
                });
            }
            function togglePieChart(id, noDataId, labels, data) {
                const canvas = document.getElementById(id);
                const noDataDiv = document.getElementById(noDataId);

                if (!labels.length || !data.length) {
                    canvas.style.display = "none";
                    noDataDiv.classList.remove("hidden");
                    return;
                }

                canvas.style.display = "block";
                noDataDiv.classList.add("hidden");

                const backgroundColors = [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                    '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6',
                    '#eab308', '#f97316', '#a855f7', '#0ea5e9'
                ].slice(0, data.length);

                new Chart(canvas, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                color: '#fff',
                                formatter: (value, ctx) => {
                                    let sum = ctx.chart._metasets[ctx.datasetIndex].total;
                                    let percentage = (value * 100 / sum).toFixed(1) + '%';
                                    return percentage;
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14,
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
