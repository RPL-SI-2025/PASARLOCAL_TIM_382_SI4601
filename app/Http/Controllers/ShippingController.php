<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingCost;

class ShippingController extends Controller
{
    public function showForm()
    {
        return view('ongkir.ongkir');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
        ]);

        $data = ShippingCost::where('destination', $request->destination)->first();

        if (!$data) {
            return back()->with('error', 'Tujuan tidak ditemukan.');
        }

        $totalOngkir = $data->distance_km * $data->cost_per_km;

        return view('ongkir.hasilongkir', [
            'destination' => $data->destination,
            'ongkir' => $totalOngkir,
        ]);
    }
}

