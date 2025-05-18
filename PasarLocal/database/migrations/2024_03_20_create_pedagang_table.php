<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedagang', function (Blueprint $table) {
            $table->id('id_pedagang');
            $table->unsignedBigInteger('id_pasar');
            $table->string('nama_pemilik', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('alamat', 100);
            $table->string('nama_toko', 100);
            $table->string('nomor_telepon', 100);
            $table->timestamps();

            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
        });

        DB::table('pedagang')->insert([
            [
                'id_pasar'       => 1,
                'nama_pemilik'   => 'Budi Santoso',
                'alamat'         => 'Jl. Melati No. 12',
                'email'         => 'budisantoso@email.com',
                'password'         => 'budisantoso123',
                'nama_toko'      => 'Toko Sembako Budi',
                'nomor_telepon'  => '081234567890',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 1,
                'nama_pemilik'   => 'Siti Aminah',
                'alamat'         => 'Jl. Kenanga No. 5',
                'email'         => 'sitiaminah@email.com',
                'password'         => 'sitiaminah123',
                'nama_toko'      => 'Aminah Grosir',
                'nomor_telepon'  => '082345678901',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 2,
                'nama_pemilik'   => 'Rahmat Hidayat',
                'alamat'         => 'Jl. Anggrek No. 7',
                'email'         => 'rahmathidayat@email.com',
                'password'         => 'rahmathidayat123',
                'nama_toko'      => 'Rahmat Elektronik',
                'nomor_telepon'  => '083456789012',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('pedagang');
    }
};
