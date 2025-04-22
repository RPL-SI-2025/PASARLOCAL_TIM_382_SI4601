<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $pasar = Pasar::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_pasar', 'LIKE', '%' . $search . '%')
                      ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('nama_pasar')
            ->get();

        return view('admin.pasar.index', compact('pasar', 'search'));
    }

    public function create()
    {
        return view('admin.pasar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasar' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Generate ID Pasar (P001, P002, etc.)
        $lastPasar = Pasar::orderBy('id_pasar', 'desc')->first();
        if ($lastPasar) {
            $lastNumber = intval(substr($lastPasar->id_pasar, 1));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $data['id_pasar'] = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads_pasar'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        Pasar::create($data);

        return redirect()->route('admin.pasar.index')
            ->with('success', 'Pasar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasar = Pasar::findOrFail($id);
        return view('admin.pasar.edit', compact('pasar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasar' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $pasar = Pasar::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($pasar->gambar && file_exists(public_path('uploads_pasar/' . $pasar->gambar))) {
                unlink(public_path('uploads_pasar/' . $pasar->gambar));
            }

            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads_pasar'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        $pasar->update($data);

        return redirect()->route('admin.pasar.index')
            ->with('success', 'Pasar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pasar = Pasar::findOrFail($id);
        
        if ($pasar->gambar && file_exists(public_path('uploads_pasar/' . $pasar->gambar))) {
            unlink(public_path('uploads_pasar/' . $pasar->gambar));
        }

        $pasar->delete();

        return redirect()->route('admin.pasar.index')
            ->with('success', 'Pasar berhasil dihapus.');
    }
} 