@include('customer.partials.navbar')

<div class="container-fluid px-4 py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="mb-4 fw-bold text-success">Pembayaran QRIS</h3>
                    
                    {{-- Tampilkan total harga yang harus dibayar --}}
                    <div class="alert alert-info text-center" role="alert">
                        Total yang harus dibayar: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    <div class="text-center mb-4">
                        <img src="{{ asset('Qris/Qris.png') }}" alt="QRIS Code" class="img-fluid mb-3" style="max-width: 300px;">
                        <p class="text-muted">Silakan scan QR code di atas untuk melakukan pembayaran</p>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Hidden inputs for order data --}}
                        @foreach($request->all() as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $item)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, atau JPEG. Maksimal 2MB</small>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('checkout.show') }}" class="btn btn-secondary flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-check me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Preview image before upload
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        if (e.target.files[0].size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file terlalu besar',
                text: 'Maksimal 2MB',
            });
            e.target.value = '';
        }
    });

    // Konfirmasi pembayaran dengan SweetAlert2
    document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
        e.preventDefault();
        const fileInput = document.querySelector('input[type="file"]');
        if (!fileInput.value) {
            Swal.fire({
                icon: 'error',
                title: 'Upload Bukti Pembayaran!',
                text: 'Silakan upload bukti pembayaran terlebih dahulu.',
            });
            return;
        }
        Swal.fire({
            title: 'Konfirmasi Bukti Pembayaran',
            text: 'Apakah bukti pembayaran sesuai?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Konfirmasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fileInput.closest('form').submit();
            }
        });
    });
</script> 