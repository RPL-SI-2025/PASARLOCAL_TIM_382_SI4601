<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriProduk::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategori = $query->get();

        return view('admin.kategori-produk.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_produk,nama_kategori|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = $gambar->getClientOriginalName();
            $gambar->move(public_path('uploads_kategori'), $namaFile);
        }

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
            'gambar' => $namaFile,
        ]);

        return redirect('/admin/kategori-produk')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('admin.kategori-produk.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = $gambar->getClientOriginalName();
            $gambar->move(public_path('uploads_kategori'), $namaFile);
            $kategori->gambar = $namaFile;
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect('/admin/kategori-produk')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->delete();

        return redirect('/admin/kategori-produk')->with('success', 'Kategori berhasil dihapus.');
    }
}
