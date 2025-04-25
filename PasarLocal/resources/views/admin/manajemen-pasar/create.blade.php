<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasar - PasarLocal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 2px;
        }
        .card {
            border: 1px solid #28a745;
        }
        .card-header {
            background-color: #28a745;
            color: white;
        }
        .form-label {
            color: #495057;
        }
        .btn-secondary, .btn-success {
            font-weight: bold;
        }
        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .coordinates-info {
            margin-top: 10px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .map-search-container {
            margin-bottom: 10px;
            position: relative;
        }
        .map-search-box {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ced4da;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 9999;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .search-result-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .search-result-item:hover {
            background-color: #f8f9fa;
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Tambah Pasar</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manajemen-pasar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_pasar" class="form-label">Nama Pasar</label>
                        <input type="text" name="nama_pasar" class="form-control @error('nama_pasar') is-invalid @enderror" id="nama_pasar" value="{{ old('nama_pasar') }}" required>
                        @error('nama_pasar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi di Peta</label>
                        <div class="map-search-container">
                            <input type="text" id="map-search" class="map-search-box" placeholder="Cari lokasi...">
                            <div id="search-results" class="search-results"></div>
                        </div>
                        <div id="map"></div>
                        <div class="coordinates-info">
                            <strong>Koordinat yang dipilih:</strong>
                            <span id="selected-coordinates">Belum dipilih</span>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Alamat</label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" value="{{ old('lokasi') }}" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Pasar</label><br>
                        <input type="file" name="gambar" class="form-control mt-2 @error('gambar') is-invalid @enderror" id="gambar" required>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.manajemen-pasar.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Geocoder JS -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.9175, 107.6191], 13); // Default ke Bandung

        // Tambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan kontrol pencarian
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).addTo(map);

        var marker;
        var searchTimeout;
        var searchResults = document.getElementById('search-results');
        var mapSearch = document.getElementById('map-search');

        // Event handler untuk input pencarian
        mapSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 3) {
                searchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(result => {
                                const div = document.createElement('div');
                                div.className = 'search-result-item';
                                div.textContent = result.display_name;
                                div.addEventListener('click', () => {
                                    selectLocation(result);
                                });
                                searchResults.appendChild(div);
                            });
                            searchResults.style.display = 'block';
                        } else {
                            searchResults.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });

        // Fungsi untuk memilih lokasi dari hasil pencarian
        function selectLocation(result) {
            const lat = parseFloat(result.lat);
            const lon = parseFloat(result.lon);
            
            // Update peta
            map.setView([lat, lon], 16);
            
            // Update marker
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lon]).addTo(map);
            
            // Update form
            mapSearch.value = result.display_name;
            document.getElementById('lokasi').value = result.display_name;
            updateCoordinatesAndAddress({ lat: lat, lng: lon });
            
            // Sembunyikan hasil pencarian
            searchResults.style.display = 'none';
        }

        // Event handler untuk hasil pencarian dari kontrol Leaflet
        geocoder.on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());

            if (marker) {
                map.removeLayer(marker);
            }

            var latlng = e.geocode.center;
            marker = L.marker(latlng).addTo(map);
            updateCoordinatesAndAddress(latlng);
        });

        // Event handler untuk klik pada peta
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            updateCoordinatesAndAddress(e.latlng);
        });

        // Fungsi untuk update koordinat dan alamat
        function updateCoordinatesAndAddress(latlng) {
            document.getElementById('selected-coordinates').textContent = 
                `Latitude: ${latlng.lat.toFixed(6)}, Longitude: ${latlng.lng.toFixed(6)}`;
            
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('lokasi').value = data.display_name;
                        mapSearch.value = data.display_name;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Sembunyikan hasil pencarian saat klik di luar
        document.addEventListener('click', function(e) {
            if (!searchResults.contains(e.target) && e.target !== mapSearch) {
                searchResults.style.display = 'none';
            }
        });

        // Fungsi untuk mencari lokasi berdasarkan input alamat
        document.getElementById('lokasi').addEventListener('change', function() {
            const query = this.value;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        
                        map.setView([lat, lon], 16);

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker([lat, lon]).addTo(map);
                        updateCoordinatesAndAddress({ lat: lat, lng: lon });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html> 