<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ExportExcel implements FromArray
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // Ubah sesuai struktur data dashboard kamu
        return [
            ['Kategori', 'Nama', 'Total'],

            ...collect($this->data['revenuePerProduct'])->map(function ($item) {
                return ['Produk', $item['nama_produk'], $item['total']];
            })->toArray(),

            ...collect($this->data['revenuePerPedagang'])->map(function ($item) {
                return ['Pedagang', $item['nama_toko'], $item['total']];
            })->toArray(),

            ...collect($this->data['revenuePerPasar'])->map(function ($item) {
                return ['Pasar', $item['nama_pasar'], $item['total']];
            })->toArray(),

            ...collect($this->data['customerSegmentation'])->map(function ($item) {
                return ['Kecamatan', $item['kecamatan'], $item['total']];
            })->toArray(),

            ...collect($this->data['onlineUsers'])->map(function ($item) {
                return ['Online', $item['name'], $item['email']];
            })->toArray(),
        ];
    }
}
