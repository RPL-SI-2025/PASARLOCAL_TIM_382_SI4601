<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedagang;

class PedagangSeeder extends Seeder
{
    public function run()
    {
        Pedagang::create([
            'id_pedagang' => 1,
            'nama_toko' => 'Toko Default',
            'nama_pemilik' => 'Admin',
            'alamat' => 'Alamat Default',
            'nomor_telepon' => '08123456789'
        ]);
    }
} 