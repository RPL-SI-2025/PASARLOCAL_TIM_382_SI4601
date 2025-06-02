<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PasarLocal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .brand-logo {
            height: 60px;
            width: auto;
            margin-right: 15px;
            object-fit: contain;
            max-width: 200px;
        }
        .header-container {
            background-color: white;
            padding: 12px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .search-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            width: 400px;
        }

        .search-container input {
            background-color: transparent;
            border: none;
            padding: 12px 40px;
        }

        .search-container input:focus {
            box-shadow: none;
            background-color: transparent;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .market-card {
            height: 240px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transform: scale(1);
            transition: transform 0.3s ease-in-out;
        }

        .market-card:hover {
            transform: scale(1.05);
        }

        .market-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .market-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .product-card img {
            height: 180px;
            object-fit: cover;
        }

        .category-btn {
            padding: 8px 20px;
            border-radius: 20px;
        }

        .rating-dots {
            display: flex;
            gap: 3px;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #e0e0e0;
        }

        .dot.active {
            background-color: #198754;
        }

        /* Search Modal Styles */
        .search-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .search-modal-content {
            position: relative;
            top: 80px;
            margin: auto;
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .search-tab {
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }

        .search-tab.active {
            color: #198754;
        }

        .search-tab.active::after {
            content: '';
            position: absolute;
            bottom: -11px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #198754;
        }

        .search-input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input-group input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }

        .search-input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-results {
            max-height: 400px;
            overflow-y: auto;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .search-result-info h6 {
            margin: 0;
            font-size: 14px;
            color: #212529;
        }

        .search-result-info p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }

        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .category-tag {
            padding: 5px 15px;
            background: #f8f9fa;
            border-radius: 20px;
            font-size: 14px;
            color: #198754;
            cursor: pointer;
            border: 1px solid #198754;
        }

        .category-tag:hover {
            background: #198754;
            color: white;
        }
    </style>
</head>
<body>
    @include('customer.partials.navbar')
    <!-- Main Content -->
    <div class="container-fluid px-4">
        <!-- Discover Section -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Discover, Pasar Tradisional</h4>
            </div>
            <div class="row g-4">
                @foreach($markets as $market)
                    <div class="col-md-6">
                        <a href="{{ route('customer.pasar.show', $market->id_pasar) }}" style="text-decoration:none;color:inherit;">
                            <div class="market-card">
                                <img src="{{ asset('uploads_pasar/' . $market->gambar) }}" alt="{{ $market->nama_pasar }}">
                                <div class="market-info">
                                    <h5 class="mb-1">{{ $market->nama_pasar }}</h5>
                                    <p class="mb-0 small">{{ $market->alamat }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchTrigger = document.getElementById('searchTrigger');
            const searchModal = document.getElementById('searchModal');
            const searchInput = document.getElementById('searchInput');
            const searchTabs = document.querySelectorAll('.search-tab');
            const categoryTags = document.getElementById('categoryTags');
            const searchResults = document.getElementById('searchResults');

            // Categories data
            const categories = [
                'Sayur', 'Buah-buahan', 'Daging Sapi', 'Daging Ayam', 'Ikan Laut',
                'Rempah & Bumbu', 'Makanan Instan', 'Produk Olahan Daging', 'Produk Olahan Nabati',
                'Bahan Pokok', 'Minuman'
            ];

            // Load categories
            function loadCategories() {
                categoryTags.innerHTML = categories.map(category =>
                    `<div class="category-tag" data-category="${category}">${category}</div>`
                ).join('');
            }

            // Show modal
            searchTrigger.addEventListener('click', function() {
                searchModal.style.display = 'block';
                searchInput.focus();
                loadCategories();
            });

            // Close modal when clicking outside
            searchModal.addEventListener('click', function(e) {
                if (e.target === searchModal) {
                    searchModal.style.display = 'none';
                }
            });

            // Tab switching
            searchTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    searchTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    searchInput.placeholder = `Cari ${this.textContent.toLowerCase()}...`;
                    performSearch();
                });
            });

            // Search functionality
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });

            // Category tag click
            categoryTags.addEventListener('click', function(e) {
                if (e.target.classList.contains('category-tag')) {
                    searchInput.value = e.target.textContent;
                    performSearch();
                }
            });

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeTab = document.querySelector('.search-tab.active').dataset.tab;

                if (activeTab === 'products') {
                    // Product search data
                    const products = [
                        // Sayur
                        { name: 'Bayam Hijau', category: 'Sayur', image: 'bayam_hijau.jpg', price: '5K' },
                        { name: 'Kangkung Air', category: 'Sayur', image: 'kangkung.jpg', price: '4K' },
                        { name: 'Wortel', category: 'Sayur', image: 'wortel.jpg', price: '8K' },
                        { name: 'Kacang Panjang', category: 'Sayur', image: 'kacang_panjang.jpg', price: '6K' },
                        { name: 'Tomat Merah', category: 'Sayur', image: 'tomat_merah.jpg', price: '10K' },
                        { name: 'Selada Hijau', category: 'Sayur', image: 'selada_hijau.jpg', price: '7K' },
                        { name: 'Mentimun', category: 'Sayur', image: 'mentimun.jpg', price: '5K' },
                        { name: 'Kubis Putih', category: 'Sayur', image: 'kubis_putih.jpg', price: '8K' },
                        { name: 'Brokoli', category: 'Sayur', image: 'brokoli.jpg', price: '15K' },
                        { name: 'Buncis', category: 'Sayur', image: 'buncis.jpg', price: '6K' },
                        { name: 'Terong Ungu', category: 'Sayur', image: 'terong_ungu.jpg', price: '5K' },
                        { name: 'Labu Siam', category: 'Sayur', image: 'labu_siam.jpg', price: '4K' },
                        { name: 'Daun Singkong', category: 'Sayur', image: 'daun_singkong.jpg', price: '3K' },
                        { name: 'Bayam Merah', category: 'Sayur', image: 'bayam_merah.jpg', price: '6K' },
                        { name: 'Rebung Muda', category: 'Sayur', image: 'rebung_muda.jpg', price: '12K' },
                        { name: 'Jagung Manis', category: 'Sayur', image: 'jagung_manis.jpg', price: '8K' },
                        { name: 'Pare', category: 'Sayur', image: 'pare.jpg', price: '5K' },
                        { name: 'Sawi Hijau', category: 'Sayur', image: 'sawi_hijau.jpg', price: '4K' },
                        { name: 'Oyong', category: 'Sayur', image: 'oyong.jpg', price: '5K' },
                        { name: 'Petai', category: 'Sayur', image: 'petai.jpg', price: '15K' },

                        // Buah-buahan
                        { name: 'Apel Merah', category: 'Buah-buahan', image: 'apel_merah.jpg', price: '25K' },
                        { name: 'Pisang Ambon', category: 'Buah-buahan', image: 'pisang_ambon.jpg', price: '15K' },
                        { name: 'Mangga Harum Manis', category: 'Buah-buahan', image: 'mangga_harummanis.jpg', price: '20K' },
                        { name: 'Jeruk Medan', category: 'Buah-buahan', image: 'jeruk_medan.jpg', price: '18K' },
                        { name: 'Semangka Merah', category: 'Buah-buahan', image: 'semangka_merah.jpg', price: '30K' },
                        { name: 'Melon Hijau', category: 'Buah-buahan', image: 'melon_hijau.jpg', price: '25K' },
                        { name: 'Anggur Merah', category: 'Buah-buahan', image: 'anggur_merah.jpg', price: '45K' },
                        { name: 'Nanas Madu', category: 'Buah-buahan', image: 'nanas_madu.jpg', price: '20K' },
                        { name: 'Pepaya California', category: 'Buah-buahan', image: 'pepaya_california.jpg', price: '15K' },
                        { name: 'Buah Naga Merah', category: 'Buah-buahan', image: 'buah_naga_merah.jpg', price: '35K' },

                        // Daging Sapi
                        { name: 'Daging Sapi Has Dalam', category: 'Daging Sapi', image: 'sapi_has_dalam.jpg', price: '140K' },
                        { name: 'Daging Sapi Has Luar', category: 'Daging Sapi', image: 'sapi_has_luar.jpg', price: '130K' },
                        { name: 'Iga Sapi', category: 'Daging Sapi', image: 'iga_sapi.jpg', price: '120K' },
                        { name: 'Brisket Sapi', category: 'Daging Sapi', image: 'brisket_sapi.jpg', price: '110K' },
                        { name: 'Kikil Sapi', category: 'Daging Sapi', image: 'kikil_sapi.jpg', price: '45K' },
                        { name: 'Tetelan Sapi', category: 'Daging Sapi', image: 'tetelan_sapi.jpg', price: '80K' },
                        { name: 'Lidah Sapi', category: 'Daging Sapi', image: 'lidah_sapi.jpg', price: '90K' },
                        { name: 'Hati Sapi', category: 'Daging Sapi', image: 'hati_sapi.jpg', price: '70K' },
                        { name: 'Usus Sapi', category: 'Daging Sapi', image: 'usus_sapi.jpg', price: '40K' },
                        { name: 'Daging Sapi Giling', category: 'Daging Sapi', image: 'sapi_giling.jpg', price: '100K' },

                        // Daging Ayam
                        { name: 'Fillet Dada Ayam', category: 'Daging Ayam', image: 'fillet_dada_ayam.jpg', price: '45K' },
                        { name: 'Fillet Paha Ayam', category: 'Daging Ayam', image: 'fillet_paha_ayam.jpg', price: '40K' },
                        { name: 'Ayam Potong 1 Ekor', category: 'Daging Ayam', image: 'ayam_potong_1_ekor.jpg', price: '75K' },
                        { name: 'Ayam Potong 1/2 Ekor', category: 'Daging Ayam', image: 'ayam_potong_1_2_ekor.jpg', price: '40K' },
                        { name: 'Ayam Potong 1/4 Ekor', category: 'Daging Ayam', image: 'ayam_potong_1_4_ekor.jpg', price: '25K' },
                        { name: 'Ayam Potong 1 Kg', category: 'Daging Ayam', image: 'ayam_potong_1_kg.jpg', price: '35K' },
                        { name: 'Paha Atas Ayam', category: 'Daging Ayam', image: 'paha_atas_ayam.jpg', price: '30K' },
                        { name: 'Paha Bawah Ayam', category: 'Daging Ayam', image: 'paha_bawah_ayam.jpg', price: '25K' },
                        { name: 'Sayap Ayam', category: 'Daging Ayam', image: 'sayap_ayam.jpg', price: '28K' },
                        { name: 'Dada Ayam', category: 'Daging Ayam', image: 'dada_ayam.jpg', price: '35K' },
                        { name: 'Paha Ayam', category: 'Daging Ayam', image: 'paha_ayam.jpg', price: '30K' },
                        { name: 'Ampela Ayam', category: 'Daging Ayam', image: 'ampela_ayam.jpg', price: '15K' },
                        { name: 'Hati Ayam', category: 'Daging Ayam', image: 'hati_ayam.jpg', price: '15K' },
                        { name: 'Jantung Ayam', category: 'Daging Ayam', image: 'jantung_ayam.jpg', price: '12K' },
                        { name: 'Ceker Ayam', category: 'Daging Ayam', image: 'ceker_ayam.jpg', price: '10K' },
                        { name: 'Ayam Kampung Utuh', category: 'Daging Ayam', image: 'ayam_kampung_utuh.jpg', price: '90K' },
                        { name: 'Ayam Kampung Potong', category: 'Daging Ayam', image: 'ayam_kampung_potong.jpg', price: '50K' },

                        // Ikan Laut
                        { name: 'Ikan Salmon Fillet', category: 'Ikan Laut', image: 'ikan_salmon_fillet.jpg', price: '180K' },
                        { name: 'Ikan Tuna Fillet', category: 'Ikan Laut', image: 'ikan_tuna_fillet.jpg', price: '120K' },
                        { name: 'Ikan Tenggiri Segar', category: 'Ikan Laut', image: 'ikan_tenggiri_segar.jpg', price: '90K' },
                        { name: 'Ikan Kembung Segar', category: 'Ikan Laut', image: 'ikan_kembung_segar.jpg', price: '40K' },
                        { name: 'Ikan Bawal Putih', category: 'Ikan Laut', image: 'ikan_bawal_putih.jpg', price: '60K' },
                        { name: 'Ikan Bandeng', category: 'Ikan Laut', image: 'ikan_bandeng.jpg', price: '35K' },
                        { name: 'Ikan Kakap Merah', category: 'Ikan Laut', image: 'ikan_kakap_merah.jpg', price: '85K' },
                        { name: 'Ikan Lele', category: 'Ikan Laut', image: 'ikan_lele.jpg', price: '30K' },
                        { name: 'Udang Windu', category: 'Ikan Laut', image: 'udang_windu.jpg', price: '120K' },
                        { name: 'Udang Vaname', category: 'Ikan Laut', image: 'udang_vaname.jpg', price: '90K' },
                        { name: 'Udang Galah', category: 'Ikan Laut', image: 'udang_galah.jpg', price: '150K' },
                        { name: 'Udang Rebon', category: 'Ikan Laut', image: 'udang_rebon.jpg', price: '25K' },
                        { name: 'Cumi-Cumi Segar', category: 'Ikan Laut', image: 'cumi_cumi_segar.jpg', price: '70K' },
                        { name: 'Cumi-Cumi Fillet', category: 'Ikan Laut', image: 'cumi_cumi_fillet.jpg', price: '85K' },
                        { name: 'Kerang Hijau', category: 'Ikan Laut', image: 'kerang_hijau.jpg', price: '25K' },
                        { name: 'Kerang Laut', category: 'Ikan Laut', image: 'kerang_laut.jpg', price: '30K' },
                        { name: 'Kerang Tiram', category: 'Ikan Laut', image: 'kerang_tiram.jpg', price: '40K' },

                        // Rempah & Bumbu
                        { name: 'Daun Jeruk', category: 'Rempah & Bumbu', image: 'daun_jeruk.jpg', price: '3K' },
                        { name: 'Daun Salam', category: 'Rempah & Bumbu', image: 'daun_salam.jpg', price: '3K' },
                        { name: 'Daun Pandan', category: 'Rempah & Bumbu', image: 'daun_pandan.jpg', price: '3K' },
                        { name: 'Daun Ketumbar', category: 'Rempah & Bumbu', image: 'daun_ketumbar.jpg', price: '3K' },
                        { name: 'Daun Kemangi', category: 'Rempah & Bumbu', image: 'daun_kemangi.jpg', price: '3K' },
                        { name: 'Jahe Segar', category: 'Rempah & Bumbu', image: 'jahe_segar.jpg', price: '15K' },
                        { name: 'Kunyit Segar', category: 'Rempah & Bumbu', image: 'kunyit_segar.jpg', price: '10K' },
                        { name: 'Lengkuas Segar', category: 'Rempah & Bumbu', image: 'lengkuas_segar.jpg', price: '8K' },
                        { name: 'Sereh Segar', category: 'Rempah & Bumbu', image: 'sereh_segar.jpg', price: '5K' },
                        { name: 'Kemiri', category: 'Rempah & Bumbu', image: 'kemiri.jpg', price: '4K' },
                        { name: 'Kayu Manis', category: 'Rempah & Bumbu', image: 'kayu_manis.jpg', price: '5K' },
                        { name: 'Cengkeh', category: 'Rempah & Bumbu', image: 'cengkeh.jpg', price: '8K' },
                        { name: 'Pala', category: 'Rempah & Bumbu', image: 'pala.jpg', price: '6K' },
                        { name: 'Bawang Merah', category: 'Rempah & Bumbu', image: 'bawang_merah.jpg', price: '40K' },
                        { name: 'Bawang Putih', category: 'Rempah & Bumbu', image: 'bawang_putih.jpg', price: '35K' },
                        { name: 'Bawang Bombay', category: 'Rempah & Bumbu', image: 'bawang_bombay.jpg', price: '15K' },
                        { name: 'Cabai Merah', category: 'Rempah & Bumbu', image: 'cabe_merah.jpg', price: '50K' },
                        { name: 'Cabai Rawit', category: 'Rempah & Bumbu', image: 'cabe_rawit.jpg', price: '60K' },
                        { name: 'Cabai Hijau', category: 'Rempah & Bumbu', image: 'cabe_hijau.jpg', price: '45K' },
                        { name: 'Cabai Keriting', category: 'Rempah & Bumbu', image: 'cabe_keriting.jpg', price: '55K' },
                        { name: 'Cabai Kering', category: 'Rempah & Bumbu', image: 'cabe_kering.jpg', price: '40K' },

                        // Makanan Instan
                        { name: 'Indomie Goreng', category: 'Makanan Instan', image: 'indomie_goreng.jpg', price: '3.5K' },
                        { name: 'Mie Sedaap Goreng', category: 'Makanan Instan', image: 'mie_sedaap_goreng.jpg', price: '3.5K' },
                        { name: 'Soto Mie Instan', category: 'Makanan Instan', image: 'soto_mie_instans.jpg', price: '3.5K' },
                        { name: 'Supermi Goreng', category: 'Makanan Instan', image: 'supermi_goreng.jpg', price: '3K' },

                        // Produk Olahan Daging
                        { name: 'Sosis Ayam', category: 'Produk Olahan Daging', image: 'sosis_ayam.jpg', price: '25K' },
                        { name: 'Nugget Ayam', category: 'Produk Olahan Daging', image: 'nugget_ayam.jpg', price: '35K' },
                        { name: 'Bakso Sapi', category: 'Produk Olahan Daging', image: 'bakso_sapi.jpg', price: '65K' },
                        { name: 'Hamburger Patty', category: 'Produk Olahan Daging', image: 'hamburger_patty.jpg', price: '45K' },
                        { name: 'Daging Rendang Instan', category: 'Produk Olahan Daging', image: 'daging_rendang_instan.jpg', price: '55K' },
                        { name: 'Kornet Sapi', category: 'Produk Olahan Daging', image: 'kornet_sapi.jpg', price: '30K' },

                        // Produk Olahan Nabati
                        { name: 'Tahu Putih', category: 'Produk Olahan Nabati', image: 'tahu_putih.jpg', price: '10K' },
                        { name: 'Tahu Coklat', category: 'Produk Olahan Nabati', image: 'tahu_coklat.jpg', price: '12K' },
                        { name: 'Tahu Kuning', category: 'Produk Olahan Nabati', image: 'tahu_kuning.jpg', price: '11K' },
                        { name: 'Tempe Papan', category: 'Produk Olahan Nabati', image: 'tempe_papan.jpg', price: '15K' },
                        { name: 'Tempe Mendoan', category: 'Produk Olahan Nabati', image: 'tempe_mendoan.jpg', price: '12K' },

                        // Bahan Pokok
                        { name: 'Beras', category: 'Bahan Pokok', image: 'beras_putih.jpg', price: '75K' },
                        { name: 'Gula Pasir', category: 'Bahan Pokok', image: 'gula_pasir.jpg', price: '15K' },
                        { name: 'Garam', category: 'Bahan Pokok', image: 'garam.jpg', price: '5K' },
                        { name: 'Tepung Terigu', category: 'Bahan Pokok', image: 'tepung_terigu.jpg', price: '15K' },
                        { name: 'Tepung Beras', category: 'Bahan Pokok', image: 'tepung_beras.jpg', price: '12K' },
                        { name: 'Minyak Goreng', category: 'Bahan Pokok', image: 'minyak_goreng.jpg', price: '25K' },
                        { name: 'Kecap Manis', category: 'Bahan Pokok', image: 'kecap_manis.jpg', price: '15K' },
                        { name: 'Santan Kelapa', category: 'Bahan Pokok', image: 'santan_kelapa.jpg', price: '10K' },
                        { name: 'Beras Merah', category: 'Bahan Pokok', image: 'beras_merah.jpg', price: '85K' },

                        // Minuman
                        { name: 'Teh Botol', category: 'Minuman', image: 'teh_botol.jpg', price: '5K' },
                        { name: 'Jus Jeruk', category: 'Minuman', image: 'jus_jeruk.jpg', price: '8K' },
                        { name: 'Kopi Instan kapal api', category: 'Minuman', image: 'kopi_instan.jpg', price: '12K' },
                        { name: 'Susu UHT', category: 'Minuman', image: 'susu_uht.jpg', price: '15K' },
                        { name: 'Air Kelapa', category: 'Minuman', image: 'air_kelapa.jpg', price: '10K' },
                        { name: 'Mineral Water', category: 'Minuman', image: 'mineral_water.jpg', price: '5K' }
                    ];

                    const filtered = products.filter(product =>
                        product.name.toLowerCase().includes(searchTerm) ||
                        product.category.toLowerCase().includes(searchTerm)
                    );

                    displayResults(filtered, 'product');
                } else {
                    
                    // Market search
                    const markets = [
                        { name: 'Pasar Kordon', location: 'Buahbatu, Bandung', image: 'pasar_temanggung.jpg', hours: '00.00 - 12.00' },
                        { name: 'Pasar Kopo', location: 'Kopo, Soreang', image: 'pasar_kopo.jpg', hours: '00.00 - 00.00' }
                    ];

                    const filtered = markets.filter(market =>
                        market.name.toLowerCase().includes(searchTerm) ||
                        market.location.toLowerCase().includes(searchTerm)
                    );

                    displayResults(filtered, 'market');
                }
            }

            function displayResults(results, type) {
                if (results.length === 0) {
                    searchResults.innerHTML = '<p class="text-center text-muted my-4">Tidak ada hasil ditemukan</p>';
                    return;
                }

                searchResults.innerHTML = results.map(item => {
                    if (type === 'product') {
                        return `
                            <div class="search-result-item">
                                <img src="/public/uploads_produk/${item.image}" alt="${item.name}">
                                <div class="search-result-info">
                                    <h6>${item.name}</h6>
                                    <p>${item.category} • ${item.price}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        return `
                            <div class="search-result-item">
                                <img src="/public/uploads_pasar/${item.image}" alt="${item.name}">
                                <div class="search-result-info">
                                    <h6>${item.name}</h6>
                                    <p>${item.location} • ${item.hours}</p>
                                </div>
                            </div>
                        `;
                    }
                }).join('');
            }

            // Initial search results
            loadCategories();
            performSearch();
        });
    </script>
</body>
</html>
