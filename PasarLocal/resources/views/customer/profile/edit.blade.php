@extends('customer.partials.navbar')

@section('title', 'Edit Profil Customer - PasarLocal')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3>Edit Profil Customer</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon', auth()->user()->nomor_telepon) }}">
                    @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', auth()->user()->alamat) }}">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                 <div class="mb-3">
                     <label for="kecamatan" class="form-label">Kecamatan</label>
                     <select name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" required>
                         <option value="">Pilih Kecamatan</option>
                         @foreach(\App\Constants\Kecamatan::getAll() as $kec)
                             <option value="{{ $kec }}" {{ old('kecamatan', auth()->user()->kecamatan) == $kec ? 'selected' : '' }}>
                                 {{ $kec }}
                             </option>
                         @endforeach
                     </select>
                     @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                 </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Foto Profil (opsional)</label>
                    <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                    @error('profile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if (auth()->user()->profile_image)
                        <div class="mt-2">
                            <img src="{{ asset('profil_customer/' . auth()->user()->profile_image) }}" alt="Foto Profil" width="120" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" onclick="window.history.back()" class="btn btn-secondary">Kembali</button>
                    <button type="submit" class="btn btn-success">Perbarui Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Add CSS for searchable dropdown library (e.g., Select2) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- Add JS for searchable dropdown library (e.g., Select2) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kecamatan').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true
            });
        });
    </script>
@endpush 