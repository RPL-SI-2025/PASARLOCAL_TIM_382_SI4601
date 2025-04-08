<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::all();
        return view('kategori-produk.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori-produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('uploads_kategori', 'public');
        }

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
            'gambar' => $gambar ? basename($gambar) : null,
        ]);

        return redirect('/kategori-produk')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('kategori-produk.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($kategori->gambar && File::exists(public_path('uploads_kategori/' . $kategori->gambar))) {
                File::delete(public_path('uploads_kategori/' . $kategori->gambar));
            }

            $gambar = $request->file('gambar')->store('uploads_kategori', 'public');
            $kategori->gambar = basename($gambar);
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect('/kategori-produk')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        if ($kategori->gambar && File::exists(public_path('uploads_kategori/' . $kategori->gambar))) {
            File::delete(public_path('uploads_kategori/' . $kategori->gambar));
        }

        $kategori->delete();

        return redirect('/kategori-produk')->with('success', 'Kategori berhasil dihapus.');
    }
}
