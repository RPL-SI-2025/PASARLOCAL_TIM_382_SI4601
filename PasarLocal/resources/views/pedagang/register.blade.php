@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrasi Toko') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pedagang.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_toko" class="form-label">{{ __('Nama Toko') }}</label>
                            <input id="nama_toko" type="text" class="form-control @error('nama_toko') is-invalid @enderror" name="nama_toko" value="{{ old('nama_toko') }}" required autofocus>
                            @error('nama_toko')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_pemilik" class="form-label">{{ __('Nama Pemilik') }}</label>
                            <input id="nama_pemilik" type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                            @error('nama_pemilik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">{{ __('Alamat') }}</label>
                            <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">{{ __('Nomor Telepon') }}</label>
                            <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                            @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Daftarkan Toko') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 