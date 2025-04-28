<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedagangController extends Controller
{
    public function register()
    {
        return view('pedagang.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:15'
        ]);

        $pedagang = new Pedagang();
        $pedagang->user_id = Auth::id();
        $pedagang->nama_toko = $request->nama_toko;
        $pedagang->nama_pemilik = $request->nama_pemilik;
        $pedagang->alamat = $request->alamat;
        $pedagang->nomor_telepon = $request->nomor_telepon;
        $pedagang->save();

        return redirect()->route('pedagang.manajemen-produk')
                        ->with('success', 'Toko berhasil didaftarkan');
    }
} 