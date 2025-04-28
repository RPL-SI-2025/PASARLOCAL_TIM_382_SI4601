<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukPedagang;
use App\Models\Pedagang;
use Illuminate\Http\Request;

class ProdukPedagangController extends Controller
{
    protected $pedagangId = 1; // Default pedagang ID untuk testing

    public function index()
    {
        $produkPedagang = ProdukPedagang::where('id_pedagang', $this->pedagangId)->get();
        $kategoris = \App\Models\KategoriProduk::all();
        return view('pedagang.manajemen_produk.index', compact('produkPedagang', 'kategoris'));
    }

    public function create()
    {
        $produk = Produk::all();
        return view('pedagang.manajemen_produk.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
            'stok' => 'required|numeric',
            'jumlah_satuan' => 'required|numeric',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $produk = \App\Models\Produk::findOrFail($request->id_produk);

        ProdukPedagang::create([
            'id_pedagang' => $this->pedagangId,
            'id_produk' => $request->id_produk,
            'stok' => $request->stok,
            'jumlah_satuan' => $request->jumlah_satuan,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'foto_produk' => $produk->gambar
        ]);

        return redirect()->route('pedagang.manajemen-produk')
                        ->with('success', 'Produk berhasil ditambahkan');
    }

    public function show($id)
    {
        $produkPedagang = ProdukPedagang::findOrFail($id);
        return view('pedagang.manajemen_produk.show', compact('produkPedagang'));
    }

    public function edit($id)
    {
        $produk_pedagang = ProdukPedagang::findOrFail($id);
        $produks = Produk::all();
        return view('pedagang.manajemen_produk.edit', compact('produk_pedagang', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|numeric',
            'jumlah_satuan' => 'required|numeric',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produkPedagang = ProdukPedagang::findOrFail($id);

        if ($request->hasFile('foto_produk')) {
            // Hapus foto lama jika ada
            if ($produkPedagang->foto_produk) {
                $old_file = public_path('uploads_produk/' . $produkPedagang->foto_produk);
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            
            $foto_produk = $request->file('foto_produk');
            $nama_foto = time() . '_' . $foto_produk->getClientOriginalName();
            $foto_produk->move(public_path('uploads_produk'), $nama_foto);
            $produkPedagang->foto_produk = $nama_foto;
        }

        $produkPedagang->stok = $request->stok;
        $produkPedagang->jumlah_satuan = $request->jumlah_satuan;
        $produkPedagang->satuan = $request->satuan;
        $produkPedagang->harga = $request->harga;
        $produkPedagang->save();

        return redirect()->route('pedagang.manajemen-produk')
                        ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produkPedagang = ProdukPedagang::findOrFail($id);
        
        // Hapus foto produk jika ada
        if ($produkPedagang->foto_produk) {
            $file_path = public_path('uploads_produk/' . $produkPedagang->foto_produk);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $produkPedagang->delete();

        return redirect()->route('pedagang.manajemen-produk')
                        ->with('success', 'Produk berhasil dihapus');
    }
} 