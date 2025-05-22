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
                'email'          => 'budisantoso@email.com',
                'password'       => 'budisantoso123',
                'nama_toko'      => 'Toko Sembako Budi',
                'nomor_telepon'  => '081234567890',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 1,
                'nama_pemilik'   => 'Siti Aminah',
                'alamat'         => 'Jl. Kenanga No. 5',
                'email'          => 'sitiaminah@email.com',
                'password'       => 'sitiaminah123',
                'nama_toko'      => 'Aminah Grosir',
                'nomor_telepon'  => '082345678901',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 2,
                'nama_pemilik'   => 'Rahmat Hidayat',
                'alamat'         => 'Jl. Anggrek No. 7',
                'email'          => 'rahmathidayat@email.com',
                'password'       => 'rahmathidayat123',
                'nama_toko'      => 'Rahmat Elektronik',
                'nomor_telepon'  => '083456789012',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 2,
                'nama_pemilik'   => 'Lina Marlina',
                'alamat'         => 'Jl. Dahlia No. 3',
                'email'          => 'linamarlina@email.com',
                'password'       => 'linamarlina123',
                'nama_toko'      => 'Toko Pakaian Lina',
                'nomor_telepon'  => '084567890123',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 3,
                'nama_pemilik'   => 'Andi Saputra',
                'alamat'         => 'Jl. Mawar No. 9',
                'email'          => 'andisaputra@email.com',
                'password'       => 'andisaputra123',
                'nama_toko'      => 'Andi Fresh Market',
                'nomor_telepon'  => '085678901234',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 3,
                'nama_pemilik'   => 'Dewi Kartika',
                'alamat'         => 'Jl. Teratai No. 4',
                'email'          => 'dewikartika@email.com',
                'password'       => 'dewikartika123',
                'nama_toko'      => 'Kartika Frozen Food',
                'nomor_telepon'  => '086789012345',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 4,
                'nama_pemilik'   => 'Hendra Wijaya',
                'alamat'         => 'Jl. Cemara No. 10',
                'email'          => 'hendrawijaya@email.com',
                'password'       => 'hendrawijaya123',
                'nama_toko'      => 'Toko Bangunan Hendra',
                'nomor_telepon'  => '087890123456',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_pasar'       => 4,
                'nama_pemilik'   => 'Fitri Andayani',
                'alamat'         => 'Jl. Cempaka No. 6',
                'email'          => 'fitriandayani@email.com',
                'password'       => 'fitriandayani123',
                'nama_toko'      => 'Fitri Herbal',
                'nomor_telepon'  => '088901234567',
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
