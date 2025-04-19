<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class ManajemenProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        $produk = $query->get();
        $kategoris = KategoriProduk::all();

        return view('admin.manajemen-produk.index', compact('produk', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriProduk::all();
        return view('admin.manajemen-produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_produk' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png,jfif|max:2048',
        ]);

        $gambar = $request->file('foto');
        $namaFile = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('uploads_produk'), $namaFile);

        Produk::create([
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'foto' => $namaFile,
        ]);

        return redirect()->route('admin.manajemen-produk.index');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = KategoriProduk::all();
        return view('admin.manajemen-produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required',
            'nama_produk' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,jfif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $gambar = $request->file('foto');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('uploads_produk'), $namaFile);
            $produk->foto = $namaFile;
        }

        $produk->id_kategori = $request->id_kategori;
        $produk->nama_produk = $request->nama_produk;
        $produk->save();

        return redirect()->route('admin.manajemen-produk.index');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('admin.manajemen-produk.index');
    }
    public function show($id)
    {
        $produk = Produk::findOrFail($id); // Mengambil produk berdasarkan ID
        return view('admin.manajemen-produk.show', compact('produk'));
    }
}
