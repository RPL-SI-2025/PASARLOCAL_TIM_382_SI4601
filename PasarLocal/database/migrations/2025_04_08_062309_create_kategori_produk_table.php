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
                ['nama_kategori' => 'Sayur Segar', 'gambar' => 'sayur.jpg'],
                ['nama_kategori' => 'Buah-buahan', 'gambar' => 'buah.jpg'],
                ['nama_kategori' => 'Daging Ayam', 'gambar' => 'ayam.jpg'],
                ['nama_kategori' => 'Ikan Laut', 'gambar' => 'ikan.jpg'],
                ['nama_kategori' => 'Rempah & Bumbu', 'gambar' => 'bumbu.jpg'],
                ['nama_kategori' => 'Daging Sapi', 'gambar' => 'daging.jpg'],
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_produk');
    }
};
