@extends('pedagang.partials.navbar')

@section('title', 'Review Produk - PasarLocal')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Review Produk</h2>

    {{-- Product Search and Category Filter Form --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('pedagang.reviews.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="product_search" class="form-label visually-hidden">Cari Produk:</label>
                    <input type="text" name="product_search" id="product_search" class="form-control" placeholder="Cari nama produk..." value="{{ $request->input('product_search') }}">
                </div>
                <div class="col-md-5">
                     <label for="category_filter" class="form-label visually-hidden">Filter Kategori:</label>
                    <select name="category" id="category_filter" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $request->input('category') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                 <div class="col-md-1">
                    <a href="{{ route('pedagang.reviews.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($reviewsByProduct as $produkPedagangId => $reviews)
            @php
                $firstReview = $reviews->first();
                $produkPedagang = $firstReview->produkPedagang;
                $produk = $produkPedagang->produk;
            @endphp
            <div class="col-12 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-2 d-flex align-items-center justify-content-center p-3">
                             @if($produk && $produk->gambar)
                                <img src="{{ asset('uploads_produk/' . $produk->gambar) }}" class="img-fluid rounded-start" alt="{{ $produk->nama_produk ?? 'Produk' }}" style="max-height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('default.jpg') }}" class="img-fluid rounded-start" alt="No Image" style="max-height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $produk->nama_produk ?? '-' }}</h5>
                                <p class="card-text"><small class="text-muted">Total Review: {{ $reviews->count() }}</small></p>

                                {{-- Button to toggle review details table --}}
                                <button class="btn btn-outline-primary btn-sm mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#reviewDetails{{ $produkPedagangId }}" aria-expanded="false" aria-controls="reviewDetails{{ $produkPedagangId }}">
                                    Lihat Detail Review ({{ $reviews->count() }})
                                </button>

                                {{-- Collapsible review details section --}}
                                <div class="collapse mt-3" id="reviewDetails{{ $produkPedagangId }}">
                                    {{-- Removed Reviewer Search Input --}}
                                    {{-- <div class="mb-3">
                                         <input type="text" class="form-control reviewer-search-input" placeholder="Cari nama reviewer...">
                                    </div> --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped review-details-table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Reviewer</th>
                                                    <th>Jumlah Dibeli</th>
                                                    <th>Total Harga Item</th>
                                                    <th>Hasil Review</th>
                                                    <th>Tanggal Pemesanan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reviews as $review)
                                                    @php
                                                        $detail = $review->pemesanan->detailPemesanans->firstWhere('produk_pedagang_id', $review->produk_pedagang_id);
                                                        $jumlah = $detail->jumlah ?? 0;
                                                        $harga = $detail->harga ?? 0;
                                                        $satuan = $review->produkPedagang->satuan ?? '';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $review->user->name ?? '-' }}</td>
                                                        <td>{{ $jumlah }} {{ $satuan }}</td>
                                                        <td>Rp{{ number_format($jumlah * $harga, 0, ',', '.') }}</td>
                                                        <td>{{ $review->feedback }}</td>
                                                         <td>{{ $review->pemesanan->created_at->format('d M Y H:i') ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                     {{-- Pagination controls will be added here --}}
                                     <div class="mt-3 reviewer-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada review untuk produk Anda saat ini.
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Removed Client-side search for reviewer name within review details table
        // document.querySelectorAll('.reviewer-search-input').forEach(function(input) {
        //     input.addEventListener('input', function() {
        //         const searchTerm = this.value.toLowerCase();
        //         const collapseElement = this.closest('.collapse');
        //         const tableResponsiveDiv = collapseElement.querySelector('.table-responsive');
        //         const tableBody = collapseElement.querySelector('tbody');
        //         const rows = tableBody.querySelectorAll('tr');
        //         let resultsFound = false;
        //
        //         // Hide all rows initially before filtering (optional, but can help with initial display)
        //         rows.forEach(function(row) {
        //             row.style.display = 'none';
        //         });
        //
        //         rows.forEach(function(row) {
        //             const reviewerName = row.querySelector('td:first-child').textContent.toLowerCase();
        //             if (reviewerName.includes(searchTerm)) {
        //                 row.style.display = ''; // Show the row
        //                 resultsFound = true;
        //             }
        //         });
        //
        //         // Show or hide the table and message based on results found
        //         const noResultsMessage = collapseElement.querySelector('.no-reviewer-results-message');
        //
        //         if (resultsFound) {
        //             if (tableResponsiveDiv) tableResponsiveDiv.style.display = '';
        //             if (noResultsMessage) noResultsMessage.style.display = 'none';
        //         } else {
        //             if (tableResponsiveDiv) tableResponsiveDiv.style.display = 'none';
        //             if (!noResultsMessage) {
        //                 // Add message if it doesn't exist
        //                 const msgDiv = document.createElement('div');
        //                 msgDiv.classList.add('alert', 'alert-info', 'no-reviewer-results-message');
        //                 msgDiv.textContent = 'Tidak ada reviewer dengan nama tersebut.';
        //                 collapseElement.appendChild(msgDiv);
        //             } else {
        //                 noResultsMessage.style.display = '';
        //             }
        //         }
        //     });
        // });

         // Reset search when collapse is hidden
        document.querySelectorAll('.collapse').forEach(function(collapseElement) {
            collapseElement.addEventListener('hidden.bs.collapse', function () {
                // const searchInput = this.querySelector('.reviewer-search-input'); // Removed search input
                const tableBody = this.querySelector('tbody');
                const rows = tableBody.querySelectorAll('tr');
                const tableResponsiveDiv = this.querySelector('.table-responsive');
                const noResultsMessage = this.querySelector('.no-reviewer-results-message');

                // Clear input and show all rows (only showing all rows part now)
                // if(searchInput) searchInput.value = ''; // Removed search input
                rows.forEach(function(row) {
                    row.style.display = '';
                });
                 if (tableResponsiveDiv) tableResponsiveDiv.style.display = ''; // Ensure table is shown
                 if (noResultsMessage) noResultsMessage.style.display = 'none'; // Hide message

                 // Reset to first page for pagination
                showPage(collapseElement, 1);
            });

            // Initial pagination display
             showPage(collapseElement, 1);
        });

        // Function to show a specific page of reviews
        function showPage(collapseElement, page) {
            const rowsPerPage = 5;
            const tableBody = collapseElement.querySelector('tbody');
            const rows = tableBody.querySelectorAll('tr');
            const paginationElement = collapseElement.querySelector('.reviewer-pagination');
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            rows.forEach(function(row, index) {
                const display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? '' : 'none';
                row.style.display = display;
            });

            // Update pagination controls
            if (paginationElement) {
                 paginationElement.innerHTML = ''; // Clear existing pagination
                 if (totalPages > 1) {
                    for (let i = 1; i <= totalPages; i++) {
                        const pageButton = document.createElement('button');
                        pageButton.classList.add('btn', 'btn-sm', 'me-1', page === i ? 'btn-primary' : 'btn-outline-primary');
                        pageButton.textContent = i;
                        pageButton.addEventListener('click', function() {
                            showPage(collapseElement, i);
                        });
                        paginationElement.appendChild(pageButton);
                    }
                 }
            }
        }
    });
</script>
@endpush
@endsection 