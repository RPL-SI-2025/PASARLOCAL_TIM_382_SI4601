<!DOCTYPE html>
<html>
<head>
    <title>Cek Ongkir</title>
</head>
<body>
    <h2>Cek Ongkos Kirim</h2>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('ongkir.hitung') }}" method="POST">
        @csrf
        <label for="destination">Tujuan:</label>
        <input type="text" name="destination" required>
        <button type="submit">Hitung Ongkir</button>
    </form>
</body>
</html>
