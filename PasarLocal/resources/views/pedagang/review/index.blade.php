@extends('pedagang.partials.navbar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review Produk</h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Pembeli</th>
                                    <th>Penilaian</th>
                                    <th>Feedback</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $review->produk->nama_produk }}</td>
                                        <td>{{ $review->user->name }}</td>
                                        <td>
                                            <div class="ratings">
                                                <div class="mb-1">
                                                    <small class="text-muted">Keseluruhan:</small>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="mb-1">
                                                    <small class="text-muted">Kualitas:</small>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->kualitas_produk)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="mb-1">
                                                    <small class="text-muted">Layanan:</small>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->layanan_pedagang)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($review->kritik)
                                                <strong>Kritik:</strong> {{ Str::limit($review->kritik, 50) }}<br>
                                            @endif
                                            @if($review->saran)
                                                <strong>Saran:</strong> {{ Str::limit($review->saran, 50) }}
                                            @endif
                                            @if($review->comment)
                                                <br><em>{{ Str::limit($review->comment, 50) }}</em>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('pedagang.review.show', $review->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada review untuk produk Anda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rating {
        display: inline-block;
    }
    .rating i {
        font-size: 1.2em;
    }
</style>
@endpush
