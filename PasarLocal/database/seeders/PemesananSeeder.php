<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananSeeder extends Seeder
{
    public function run()
    {
        // Jangan hapus data lama, jadi hapus truncate
        // DB::table('detail_pemesanans')->truncate();
        // DB::table('pemesanans')->truncate();

        $ongkirIds = [1, 2, 3, 4]; // id ongkir yang tersedia
        $produkPedagangIds = [1, 2, 3]; // contoh id produk_pedagang
        $pasarIds = [1, 2, 3]; // contoh id pasar
        $metode = ['COD', 'QRIS'];
        $statusPembayaran = ['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Batal'];

        // Buat pemesanan dengan tanggal bervariasi dalam 30 hari terakhir
        for ($i = 1; $i <= 10; $i++) {
            $createdAt = Carbon::now()->subDays(rand(1, 364));

            // Insert pemesanan
            $pemesananId = DB::table('pemesanans')->insertGetId([
                'customer_id' => 1,
                'ongkir_id' => $ongkirIds[array_rand($ongkirIds)],
                'total_harga' => 0, // nanti update setelah insert detail
                'bukti_pembayaran' => NULL,
                'metode_pembayaran' => $metode[array_rand($metode)],
                'status' => $statusPembayaran[array_rand($statusPembayaran)],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $totalHarga = 0;

            // Insert 1-3 detail pemesanan untuk pemesanan ini
            $detailCount = rand(1, 100);
            for ($j = 0; $j < $detailCount; $j++) {
                $jumlah = rand(1, 5);
                $harga = rand(10000, 50000);

                DB::table('detail_pemesanans')->insert([
                    'pemesanan_id' => $pemesananId,
                    'produk_pedagang_id' => $produkPedagangIds[array_rand($produkPedagangIds)],
                    'id_pasar' => $pasarIds[array_rand($pasarIds)],
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $totalHarga += $jumlah * $harga;
            }

            // Update total_harga pemesanan
            DB::table('pemesanans')
                ->where('id', $pemesananId)
                ->update(['total_harga' => $totalHarga]);
        }
    }
}
