@extends('pedagang.layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4">Tambah Produk</h3>
                    <form method="POST" action="{{ route('pedagang.manajemen_produk.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="id_produk" class="form-label">Pilih Produk</label>
                            <select id="id_produk" class="form-select @error('id_produk') is-invalid @enderror" name="id_produk" required onchange="updateProductInfo()">
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $p)
                                    <option value="{{ $p->id }}" data-img="{{ asset('uploads_produk/' . $p->gambar) }}" data-kategori="{{ $p->kategori->nama_kategori ?? '-' }}" data-deskripsi="{{ $p->deskripsi_produk ?? '' }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 text-center" id="preview-img" style="display:none;">
                            <img id="produk-img" src="" alt="Preview" style="width:120px; height:120px; object-fit:cover; border-radius:10px; margin-bottom:10px;">
                        </div>
                        <div class="mb-3" id="preview-deskripsi" style="display:none;">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea id="deskripsi_produk" class="form-control" rows="2" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" id="kategori" class="form-control" value="" readonly>
                        </div>
                        <div class="mb-3 row">
                            <label class="form-label">Jumlah per Satuan</label>
                            <div class="col-6">
                                <input type="number" id="jumlah_satuan" name="jumlah_satuan" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-6">
                                <select id="satuan" name="satuan" class="form-select" required>
                                    <option value="gram">gram</option>
                                    <option value="kg">kg</option>
                                    <option value="pcs">pcs</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input id="stok" type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok') }}" required>
                            @error('stok')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" required>
                            @error('harga')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" style="font-size:1.1rem;">Tambah Produk</button>
                            <a href="{{ route('pedagang.manajemen_produk.index') }}" class="btn btn-secondary btn-lg" style="font-size:1.1rem; background:#656d78; border:none;">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function updateProductInfo() {
    var select = document.getElementById('id_produk');
    var selected = select.options[select.selectedIndex];
    var img = selected.getAttribute('data-img');
    var kategori = selected.getAttribute('data-kategori');
    var deskripsi = selected.getAttribute('data-deskripsi');
    if (img && selected.value) {
        document.getElementById('produk-img').src = img;
        document.getElementById('preview-img').style.display = '';
    } else {
        document.getElementById('preview-img').style.display = 'none';
    }
    if (deskripsi && selected.value) {
        document.getElementById('deskripsi_produk').value = deskripsi;
        document.getElementById('preview-deskripsi').style.display = '';
    } else {
        document.getElementById('preview-deskripsi').style.display = 'none';
    }
    document.getElementById('kategori').value = kategori || '';
}
</script>
@endsection
