<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ongkir;
use App\Models\Pasar;

class OngkirController extends Controller
{
    public function index()
    {
        $pasar = Pasar::all();
        return view('admin.ongkir.index', compact('pasar'));
    }

    public function create()
    {
        $pasar = Pasar::all();
        return view('admin.ongkir.create', compact('pasar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pasar' => 'required|exists:pasar,id_pasar',
            'kecamatan_tujuan' => 'required|string|max:100',
            'ongkir' => 'required|integer|min:0'
        ]);

        Ongkir::create([
            'id_pasar' => $request->id_pasar,
            'kecamatan_tujuan' => $request->kecamatan_tujuan,
            'ongkir' => (int)$request->ongkir
        ]);

        return redirect()->route('admin.ongkir.index')->with('success', 'Data berhasil disimpan!');
    }

    public function detail()
    {

        // ambil hanya ongkir yang id_pasar == $id
        $pasar = Pasar::all();
        $ongkirs = Ongkir::all();

        return view('admin.ongkir.index-detail', compact('ongkirs', 'pasar'));
    }

    public function edit($id)
    {
        $ongkir = Ongkir::findOrFail($id);
        $pasar = Pasar::all();
        return view('admin.ongkir.edit', compact('ongkir', 'pasar'));
    }

    public function update(Request $request, $id)
    {
        {
            // 1. Validasi input
            $validator = Validator::make($request->all(), [
                'kecamatan_tujuan' => 'required|string|max:255',
                'ongkir' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // 2. Cari data yang akan diupdate
            $ongkir = Ongkir::findOrFail($id);

            // 3. Update data
            $ongkir->update([
                'kecamatan_tujuan' => $request->kecamatan_tujuan,
                'ongkir' => $request->ongkir
            ]);

            // 4. Redirect dengan pesan sukses
            return redirect()
                ->route('admin.ongkir.detail')
                ->with('success', 'Data ongkir berhasil diperbarui!');
        }

    }
    public function destroy($id)
    {
        try {
            $ongkir = Ongkir::findOrFail($id);
            $ongkir->delete();

            DB::statement('ALTER TABLE ongkir AUTO_INCREMENT = 1');
            return redirect()
                ->route('admin.ongkir.detail')
                ->with('success', 'Data ongkir berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
