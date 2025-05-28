@include('pedagang.partials.navbar')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3>Profil Pedagang</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Foto Profil" width="120" class="img-thumbnail mb-3">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama_pemilik) }}&background=28a745&color=fff" width="120" class="img-thumbnail mb-3" alt="Avatar">
                    @endif
                </div>
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr><th>Nama Pemilik</th><td>{{ auth()->user()->nama_pemilik }}</td></tr>
                        <tr><th>Email</th><td>{{ auth()->user()->email }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ auth()->user()->nomor_telepon }}</td></tr>
                        <tr><th>Alamat</th><td>{{ auth()->user()->alamat }}</td></tr>
                        <tr><th>Nama Toko</th><td>{{ auth()->user()->nama_toko }}</td></tr>
                    </table>
                    <a href="{{ route('profile.edit') }}" class="btn btn-success">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div> 