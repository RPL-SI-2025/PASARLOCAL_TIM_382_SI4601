<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = is_array($data) ? $data : (array) $data;
    }

    public function sheets(): array
    {
        return [
            'Pendapatan Produk' => new class($this->data['revenuePerProduct']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Produk' => $i->nama_produk,
                        'Total' => $i->total,
                    ]);
                }
                public function headings(): array { return ['Produk', 'Total']; }
            },

            'Pendapatan Pedagang' => new class($this->data['revenuePerPedagang']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Nama Toko' => $i->nama_toko,
                        'Total' => $i->total,
                    ]);
                }
                public function headings(): array { return ['Nama Toko', 'Total']; }
            },

            'Pendapatan Pasar' => new class($this->data['revenuePerPasar']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Pasar' => $i->nama_pasar,
                        'Total' => $i->total,
                    ]);
                }
                public function headings(): array { return ['Pasar', 'Total']; }
            },

            'Segmentasi Customer' => new class($this->data['customerSegmentation']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Kecamatan' => $i->kecamatan,
                        'Jumlah' => $i->total,
                    ]);
                }
                public function headings(): array { return ['Kecamatan', 'Jumlah']; }
            },

            'Customer Online' => new class($this->data['onlineUsers']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Nama' => $i->name,
                        'Email' => $i->email,
                    ]);
                }
                public function headings(): array { return ['Nama', 'Email']; }
            },

            'Pendapatan Harian' => new class($this->data['dailyRevenue']) implements FromCollection, WithHeadings {
                protected $items;
                public function __construct($items) { $this->items = $items; }
                public function collection() {
                    return collect($this->items)->map(fn($i) => [
                        'Tanggal' => $i->tanggal,
                        'Total' => $i->total,
                    ]);
                }
                public function headings(): array { return ['Tanggal', 'Total']; }
            },
        ];
    }
}
