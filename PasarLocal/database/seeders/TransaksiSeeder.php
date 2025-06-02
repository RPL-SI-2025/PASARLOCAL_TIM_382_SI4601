<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transaksis')->insert([
            [
                'id_pasar' => 1,
                'id_produk_pedagang' => 1,
                'id_user' => 2, // pastikan user id 2 ada
                'quantity' => 2,
                'ulasan' => 'bagus enak sekali',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pasar' => 1,
                'id_produk_pedagang' => 2,
                'id_user' => 2, // pastikan user id 2 ada
                'quantity' => 2,
                'ulasan' => 'bagus enak sekali',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
