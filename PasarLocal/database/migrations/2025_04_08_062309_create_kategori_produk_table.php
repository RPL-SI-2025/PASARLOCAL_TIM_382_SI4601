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
                ['nama_kategori' => 'Sayur', 'gambar' => 'sayur.jpg'],
                ['nama_kategori' => 'Buah-buahan', 'gambar' => 'buah.jpg'],
                ['nama_kategori' => 'Daging Sapi', 'gambar' => 'daging_sapi.jpg'],
                ['nama_kategori' => 'Daging Ayam', 'gambar' => 'daging_ayam.jpg'],
                ['nama_kategori' => 'Ikan Laut', 'gambar' => 'ikan_laut.jpg'],
                ['nama_kategori' => 'Rempah & Bumbu', 'gambar' => 'bumbu.jpg'],
                ['nama_kategori' => 'Makanan Instan', 'gambar' => 'makanan_instan.jpg'],
                ['nama_kategori' => 'Produk Olahan Daging', 'gambar' => 'produk_olahan_daging.jpg'],
                ['nama_kategori' => 'Produk Olahan Nabati', 'gambar' => 'produk_olahan_nabati.jpg'],
                ['nama_kategori' => 'Bahan Pokok', 'gambar' => 'bahan_pokok.jpg'],
                ['nama_kategori' => 'Minuman', 'gambar' => 'minuman.jpg'],
            ]);
            
        });
    }

    public function down(): void
    {
    
        Schema::dropIfExists('kategori_produk');
    }
};
