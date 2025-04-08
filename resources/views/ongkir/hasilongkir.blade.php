<!DOCTYPE html>
<html>
<head>
    <title>Hasil Ongkir</title>
</head>
<body>
    <h2>Ongkir ke {{ $destination }}</h2>
    <p>Total Ongkir: Rp {{ number_format($ongkir, 0, ',', '.') }}</p>
    <a href="/ongkir">Cek lagi</a>
</body>
</html>
