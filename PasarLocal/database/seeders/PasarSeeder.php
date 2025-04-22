<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasarSeeder extends Seeder
{
    public function run(): void
    {
        DB::afterCommit(function () {
            DB::table('pasar')->insert([
                [
                    'nama_pasar' => 'Pasar Gedebage',
                    'lokasi' => 'Jl. Gedebage, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Gedebage',
                    'gambar' => 'uploads_pasar/pasar gedebage.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Cicadas',
                    'lokasi' => 'Jl. Ibrahim Adjie, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Cicadas',
                    'gambar' => 'uploads_pasar/pasar cicadas.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Kosambi',
                    'lokasi' => 'Jl. Jend. Ahmad Yani, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Kosambi',
                    'gambar' => 'uploads_pasar/pasar kosambi.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Cicaheum',
                    'lokasi' => 'Jl. Jend. Ahmad Yani, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Cicaheum',
                    'gambar' => 'uploads_pasar/Pasar Cicaheum.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Ujungberung',
                    'lokasi' => 'Jl. A.H. Nasution, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Ujungberung',
                    'gambar' => 'uploads_pasar/pasar ujungberung.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Gegerkalong',
                    'lokasi' => 'Jl. Gegerkalong Hilir, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Gegerkalong',
                    'gambar' => 'uploads_pasar/pasar gegerkalong.jpeg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Kiaracondong',
                    'lokasi' => 'Jl. Kiaracondong, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Kiaracondong',
                    'gambar' => 'uploads_pasar/pasar kiaracondong.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Anyar',
                    'lokasi' => 'Jl. Anyar, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Anyar',
                    'gambar' => 'uploads_pasar/pasar anyar.jpeg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Cipahit',
                    'lokasi' => 'Jl. Cipahit, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Cipahit',
                    'gambar' => 'uploads_pasar/pasar cipahit.jpeg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
                [
                    'nama_pasar' => 'Pasar Kordon',
                    'lokasi' => 'Jl. Kordon, Bandung',
                    'deskripsi' => 'Pasar tradisional di daerah Kordon',
                    'gambar' => 'uploads_pasar/pasar kordon.jpg',
                    'created_at' => now(),
                    'updated_at' => null
                ],
            ]);
        });
    }
} 