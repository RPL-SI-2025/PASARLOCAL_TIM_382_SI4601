<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use App\Models\Pasar;
use Illuminate\Http\Request;

class PedagangController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedagang::with('pasar');

        // Filter by pasar
        if ($request->has('pasar') && $request->pasar != '') {
            $query->where('id_pasar', $request->pasar);
        }

        // Search by nama_pedagang
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pedagang', 'like', '%' . $request->search . '%');
        }

        $pedagang = $query->paginate(12);
        $pasar = Pasar::all();

        return view('admin.manajemen-pedagang.index', compact('pedagang', 'pasar'));
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('admin.manajemen-pedagang.create', compact('pasar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasar' => 'required',
            'nama_pedagang' => 'required',
            'lokasi_toko' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads_pedagang'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        Pedagang::create($data);

        return redirect()->route('admin.manajemen-pedagang.index')
            ->with('success', 'Pedagang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pedagang = Pedagang::findOrFail($id);
        $pasar = Pasar::all();
        return view('admin.manajemen-pedagang.edit', compact('pedagang', 'pasar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasar' => 'required',
            'nama_pedagang' => 'required',
            'lokasi_toko' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $pedagang = Pedagang::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($pedagang->gambar && file_exists(public_path('uploads_pedagang/' . $pedagang->gambar))) {
                unlink(public_path('uploads_pedagang/' . $pedagang->gambar));
            }

            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads_pedagang'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        $pedagang->update($data);

        return redirect()->route('admin.manajemen-pedagang.index')
            ->with('success', 'Pedagang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pedagang = Pedagang::findOrFail($id);
        
        if ($pedagang->gambar && file_exists(public_path('uploads_pedagang/' . $pedagang->gambar))) {
            unlink(public_path('uploads_pedagang/' . $pedagang->gambar));
        }

        $pedagang->delete();

        return redirect()->route('admin.pedagang.index')
            ->with('success', 'Pedagang berhasil dihapus.');
    }
} 