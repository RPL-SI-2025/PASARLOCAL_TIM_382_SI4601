@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Manajemen Pesanan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Pencarian --}}
        <form action="{{ route('admin.manajemen-pesanan.index') }}" method="GET" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari pelanggan..."
                value="{{ request()->query('search') }}">
            <button class="btn btn-success">Cari</button>
        </form>

        {{-- Navigasi Tab Status --}}
        @php
            $statuses = ['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Batal'];
        @endphp
        <ul class="nav nav-pills mb-3" id="status-tabs" role="tablist">
            @foreach ($statuses as $key => $status)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($key == 0) active @endif" id="tab-{{ $key }}"
                        data-bs-toggle="pill" data-bs-target="#content-{{ $key }}" type="button" role="tab">
                        {{ $status }}
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- Konten Tiap Tab --}}
        <div class="tab-content" id="status-tabsContent">
            @foreach ($statuses as $key => $status)
                <div class="tab-pane fade @if ($key == 0) show active @endif"
                    id="content-{{ $key }}" role="tabpanel">
                    @php
                        $orders = $groupedOrders[$status] ?? collect();
                    @endphp

                    @if ($orders->isNotEmpty())
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Total</th>
                                    <th>Status Bayar</th>
                                    <th>Status Pesanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>INV/{{ $order->id }}</td>
                                        <td>{{ $order->customer->nama_customer }}</td>
                                        <td>
                                            @if($order->bukti_pembayaran && file_exists(public_path($order->bukti_pembayaran)))
                                                <img src="{{ asset($order->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="width:120px; height:120px; object-fit:cover; border-radius:8px; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#zoomBuktiModal{{ $order->id }}">
                                                <!-- Modal Zoom Bukti Pembayaran -->
                                                <div class="modal fade" id="zoomBuktiModal{{ $order->id }}" tabindex="-1" aria-labelledby="zoomBuktiLabel{{ $order->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="zoomBuktiLabel{{ $order->id }}">Bukti Pembayaran</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ asset($order->bukti_pembayaran) }}" alt="Bukti Pembayaran Besar" style="max-width:100%; max-height:70vh; border-radius:12px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <form action="{{ route('admin.manajemen-pesanan.update', $order->id) }}"
                                                method="POST" class="d-flex align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select me-2" required>
                                                    @foreach ($statuses as $opt)
                                                        <option value="{{ $opt }}"
                                                            {{ $opt == $order->status ? 'selected' : '' }}>
                                                            {{ $opt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.manajemen-pesanan.show', $order->id) }}"
                                                class="btn btn-secondary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">Tidak ada pesanan dalam status <strong>{{ $status }}</strong>.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
