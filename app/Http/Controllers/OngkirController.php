<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OngkirController extends Controller
{
    public function index()
    {
        return view('ongkir.cek-ongkir');
    }

    public function cekHarga(Request $request)
    {
        $request->validate([
            'lokasi_awal' => 'required|string',
            'lokasi_tujuan' => 'required|string',
        ]);

        // Simulasi ongkir: Jarak x tarif per KM (contoh sederhana)
        $tarifPerKm = 3000; // 3rb per km
        $jarak = rand(1, 20); // Misal jarak acak 1-20km

        $biaya = $jarak * $tarifPerKm;

        return view('ongkir.cek-ongkir', [
            'dari' => $request->lokasi_awal,
            'tujuan' => $request->lokasi_tujuan,
            'biaya' => $biaya,
        ]);
    }
}
