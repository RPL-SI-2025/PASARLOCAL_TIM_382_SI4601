<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #28a745;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .market-card {
        height: 240px;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
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

    .cart-icon {
        font-size: 1.2rem;
        color: #212529;
    }

    .cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 0.3em 0.5em;
        font-size: 75%;
        font-weight: 700;
        background-color: #dc3545;
        color: white;
        border-radius: 0.25rem;
        line-height: 1;
    }
</style>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome (gunakan hanya satu versi) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo dan Search -->
        <div class="d-flex align-items-center gap-4">
            <a href="/home">
                <img src="{{ asset('uploads_logo/PASARLOCALLL.png') }}" alt="PasarLocal" class="brand-logo">
            </a>
            <div class="search-container">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                    <input type="text" class="form-control" placeholder="Cari produk atau pasar..." id="searchTrigger">
                </div>
            </div>
        </div>

        <!-- Ikon & Profil -->
        <div class="d-flex align-items-center gap-4">
            <a href="/user/messages" class="text-dark"><i class="far fa-comment-alt fs-5"></i></a>
            <a href="/user/notifications" class="text-dark"><i class="far fa-bell fs-5"></i></a>
            <a href="{{ route('cart.index') }}" class="position-relative me-3">
                <i class="fas fa-shopping-cart fs-5 cart-icon"></i>
                @if(auth()->user()->customer && auth()->user()->customer->carts()->exists())
                    <span class="cart-badge">{{ auth()->user()->customer->carts->sum(function($cart) { return $cart->items->count(); }) }}</span>
                @endif
            </a>

            <!-- User Dropdown -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 pt-2 pb-0">
                        <small class="text-muted">Signed in as</small><br>
                        <span class="fw-bold">{{ Auth::user()->email }}</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('riwayat.transaksi') }}">
                            <i class="fas fa-box me-2"></i> Riwayat Pemesanan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="search-modal" id="searchModal">
    <div class="search-modal-content">
        <div class="search-tabs">
            <div class="search-tab active" data-type="product">Produk</div>
            <div class="search-tab" data-type="market">Pasar</div>
        </div>

        <div class="search-input-group">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari produk atau pasar..." id="search-input">
        </div>

        <div class="search-results" id="searchResults">
            {{-- Results will be loaded here via AJAX --}}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        const searchModal = $('#searchModal');
        const searchInput = $('#search-input');
        const searchResults = $('#searchResults');
        const searchTabs = $('.search-tab');
        let currentSearchType = 'product'; // Default search type

        // Open search modal
        $('.search-container input').on('focus', function() {
            searchModal.fadeIn();
            searchInput.focus(); // Set focus to the modal input
        });

        // Close search modal when clicking outside the content
        searchModal.on('click', function(e) {
            if ($(e.target).is(searchModal)) {
                searchModal.fadeOut();
            }
        });

        // Handle tab clicks
        searchTabs.on('click', function() {
            searchTabs.removeClass('active');
            $(this).addClass('active');
            currentSearchType = $(this).data('type');
            performSearch(); // Perform search again with the new type
        });

        // Perform search on input change
        searchInput.on('input', function() {
            performSearch();
        });

        function performSearch() {
            const query = searchInput.val();
            if (query.length > 2) { // Perform search only if query is at least 3 characters
                $.ajax({
                    url: "{{ route('ajax.search') }}",
                    method: 'GET',
                    data: {
                        query: query,
                        type: currentSearchType
                    },
                    success: function(response) {
                        displayResults(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Search error:', error);
                        searchResults.html('<p class="text-muted text-center">Terjadi kesalahan saat mencari.</p>');
                    }
                });
            } else {
                searchResults.empty(); // Clear results if query is too short
            }
        }

        function displayResults(results) {
            searchResults.empty();

            if (currentSearchType === 'product') {
                if (results.products && results.products.length > 0) {
                    results.products.forEach(product => {
                        searchResults.append(`
                            <a href="${product.url}" class="search-result-item d-flex align-items-center text-decoration-none text-dark">
                                <img src="${product.image}" alt="${product.name}">
                                <div class="search-result-info">
                                    <h6>${product.name}</h6>
                                    <p>Produk</p>
                                </div>
                            </a>
                        `);
                    });
                } else {
                    searchResults.html('<p class="text-muted text-center">Tidak ada produk ditemukan.</p>');
                }
            } else if (currentSearchType === 'market') {
                 if (results.markets && results.markets.length > 0) {
                    results.markets.forEach(market => {
                        searchResults.append(`
                            <a href="${market.url}" class="search-result-item d-flex align-items-center text-decoration-none text-dark">
                                <img src="${market.image}" alt="${market.name}">
                                <div class="search-result-info">
                                    <h6>${market.name}</h6>
                                    <p>Pasar</p>
                                </div>
                            </a>
                        `);
                    });
                } else {
                    searchResults.html('<p class="text-muted text-center">Tidak ada pasar ditemukan.</p>');
                }
            }
        }
    });
</script>

