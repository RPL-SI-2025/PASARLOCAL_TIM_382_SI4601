@include('customer.partials.navbar')
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
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                    @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $user->alamat) }}">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select name="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach(\App\Constants\Kecamatan::getAll() as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan', $user->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Foto Profil (opsional)</label>
                    <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                    @error('profile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if ($user->profile_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto Profil" width="120" class="img-thumbnail">
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Perbarui Profil</button>
                </div>
            </form>
        </div>
    </div>
</div> 