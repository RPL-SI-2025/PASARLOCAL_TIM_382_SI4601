<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        DB::afterCommit(function () {
            DB::table('kategori_produk')->insert([
                ['nama_kategori' => 'Sayur', 'gambar' => 'sayur.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Buah-buahan', 'gambar' => 'buah.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Daging Sapi', 'gambar' => 'daging_sapi.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Daging Ayam', 'gambar' => 'daging_ayam.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Ikan Laut', 'gambar' => 'ikan_laut.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Rempah & Bumbu', 'gambar' => 'bumbu.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Makanan Instan', 'gambar' => 'makanan_instan.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Produk Olahan Daging', 'gambar' => 'produk_olahan_daging.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Produk Olahan Nabati', 'gambar' => 'produk_olahan_nabati.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Bahan Pokok', 'gambar' => 'bahan_pokok.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
                ['nama_kategori' => 'Minuman', 'gambar' => 'minuman.jpg', 'created_at' => '2025-04-02', 'updated_at' => null],
            ]);
        });        
    }

    public function down(): void
    {
    
        Schema::dropIfExists('kategori_produk');
    }
};
