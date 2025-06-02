

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Berikan Review</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('customer.review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
                <input type="hidden" name="produk_id" value="{{ $produk_id }}">

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <div class="rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="d-none" {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}" class="fas fa-star text-warning" style="cursor: pointer; font-size: 24px;"></label>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar (Opsional)</label>
                    <textarea name="komentar" id="komentar" rows="4" class="form-control @error('komentar') is-invalid @enderror">{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('customer.riwayat.show', $pemesanan->id) }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Kirim Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.rating label').forEach((star, index) => {
    star.addEventListener('mouseover', () => {
        document.querySelectorAll('.rating label').forEach((s, i) => {
            if (i <= index) {
                s.classList.add('text-warning');
            } else {
                s.classList.remove('text-warning');
            }
        });
    });
});

document.querySelector('.rating').addEventListener('mouseleave', () => {
    const selectedRating = document.querySelector('input[name="rating"]:checked');
    if (selectedRating) {
        const index = parseInt(selectedRating.value) - 1;
        document.querySelectorAll('.rating label').forEach((s, i) => {
            if (i <= index) {
                s.classList.add('text-warning');
            } else {
                s.classList.remove('text-warning');
            }
        });
    } else {
        document.querySelectorAll('.rating label').forEach(s => s.classList.remove('text-warning'));
    }
});
</script>
@endpush
@endsection
