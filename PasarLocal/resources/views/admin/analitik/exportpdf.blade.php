<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard Analitik</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Laporan Dashboard Analitik</h2>
    <p><strong>Periode:</strong> {{ $start }} s/d {{ $end }}</p>

    <h3>Pendapatan per Produk</h3>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['revenuePerProduct'] as $item)
                <tr>
                    <td>{{ $item->nama_produk }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Pendapatan per Pedagang</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Toko</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['revenuePerPedagang'] as $item)
                <tr>
                    <td>{{ $item->nama_toko }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Pendapatan per Pasar</h3>
    <table>
        <thead>
            <tr>
                <th>Pasar</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['revenuePerPasar'] as $item)
                <tr>
                    <td>{{ $item->nama_pasar }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Segmentasi Customer (Kecamatan)</h3>
    <table>
        <thead>
            <tr>
                <th>Kecamatan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['customerSegmentation'] as $item)
                <tr>
                    <td>{{ $item->kecamatan }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Laporan Pendapatan Harian</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($data['dailyRevenue'] as $revenue)
                    <tr>
                        <td>{{ $revenue->tanggal }}</td>
                        <td>Rp {{ number_format($revenue->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
</body>

</html>
