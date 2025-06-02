@extends('pedagang.partials.navbar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Review Produk</h3>
                    <div class="card-tools">
                        <a href="{{ route('pedagang.review.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Produk:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->produk->nama_produk }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Pembeli:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->user->name }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Rating Keseluruhan:</strong>
                        </div>
                        <div class="col-md-8">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Kualitas Produk:</strong>
                        </div>
                        <div class="col-md-8">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->kualitas_produk)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Layanan Pedagang:</strong>
                        </div>
                        <div class="col-md-8">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->layanan_pedagang)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Kesesuaian Deskripsi:</strong>
                        </div>
                        <div class="col-md-8">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->kesesuaian_deskripsi)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Kritik:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->kritik }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Saran:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->saran }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Komentar Tambahan:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->comment ?: '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <strong>Tanggal Review:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $review->created_at->format('d M Y H:i') }}
                        </div>
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
        font-size: 1.5em;
    }
    .ratings i {
        font-size: 0.9em;
    }
</style>
@endpush
