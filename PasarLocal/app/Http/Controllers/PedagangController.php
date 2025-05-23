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
            'id_pasar' => 'required|exists:pasar,id_pasar',
            'nama_pemilik' => 'required|string|max:100',
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:100',
            'email' => 'required|email|unique:pedagang,email|max:100',
            'password' => 'required|string|min:8|max:100',
        ]);

        Pedagang::create([
            'id_pasar' => $request->id_pasar,
            'nama_pemilik' => $request->nama_pemilik,
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

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
            'id_pasar' => 'required|exists:pasar,id_pasar',
            'nama_pemilik' => 'required|string|max:100',
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:100',
        ]);

        $pedagang = Pedagang::findOrFail($id);

        $pedagang->update([
            'id_pasar' => $request->id_pasar,
            'nama_pemilik' => $request->nama_pemilik,
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

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

        return redirect()->route('admin.manajemen-pedagang.index')
            ->with('success', 'Pedagang berhasil dihapus.');
    }
} 