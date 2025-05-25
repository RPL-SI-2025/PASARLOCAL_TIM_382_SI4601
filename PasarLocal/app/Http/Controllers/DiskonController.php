<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DiskonController extends Controller
{
    /**
     * Display a listing of the discounts.
     */
    public function index()
    {
        $diskons = Diskon::latest()->paginate(10);
        return view('diskons.index', compact('diskons'));
    }

    /**
     * Store a newly created discount.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_diskon' => 'required|in:amount,shipping',
            'max_diskon' => 'nullable|numeric|min:0',
            'min_pembelian' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $diskon = Diskon::create([
                'kode_diskon' => 'DISC-' . Str::random(8),
                'nama_diskon' => $request->nama_diskon,
                'deskripsi' => $request->deskripsi,
                'jenis_diskon' => $request->jenis_diskon,
                'max_diskon' => $request->max_diskon,
                'min_pembelian' => $request->min_pembelian,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'aktif' => true
            ]);

            return redirect()->route('diskons.index')->with('success', 'Diskon berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan diskon: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified discount.
     */
    public function show($id)
    {
        $diskon = Diskon::findOrFail($id);
        return view('diskons.show', compact('diskon'));
    }

    /**
     * Update the specified discount.
     */
    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_diskon' => 'required|in:amount,shipping',
            'max_diskon' => 'nullable|numeric|min:0',
            'min_pembelian' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $diskon->update([
                'nama_diskon' => $request->nama_diskon,
                'deskripsi' => $request->deskripsi,
                'jenis_diskon' => $request->jenis_diskon,
                'max_diskon' => $request->max_diskon,
                'min_pembelian' => $request->min_pembelian,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
            ]);

            return redirect()->route('diskons.index')->with('success', 'Diskon berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui diskon: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified discount.
     */
    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);

        try {
            $diskon->forceDelete();

            return redirect()->route('diskons.index')->with('success', 'Diskon berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus diskon: ' . $e->getMessage());
        }
    }
} 