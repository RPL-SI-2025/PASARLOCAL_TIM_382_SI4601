<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedagang;
use App\Models\Pasar;

class PedagangSeeder extends Seeder
{
    public function run()
    {
        // Create default pedagang using existing pasar
        Pedagang::create([
            'id_pedagang' => 999, // Using a high number to avoid conflicts
            'id_pasar' => 1, // Using existing Pasar Kordon
            'nama_toko' => 'Toko Default',
            'nama_pemilik' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Alamat Default',
            'nomor_telepon' => '08123456789'
        ]);
    }
} 