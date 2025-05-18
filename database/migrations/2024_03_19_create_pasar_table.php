<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pasar', function (Blueprint $table) {
            $table->string('id_pasar', 10)->primary();
            $table->string('nama_pasar');
            $table->text('lokasi');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });

        DB::afterCommit(function () {
            DB::table('pasar')->insert([
                [
                    'id_pasar' => 'P001',
                    'nama_pasar' => 'Pasar Kordon',
                    'lokasi' => 'Pasar Kordon, Jalan Marga Cinta, Kujangsari, Bandung Kidul, Bandung City, West Java, Java, 30286, Indonesia',
                    'deskripsi' => 'Pasar Kordon, terletak di Bandung Kidul, dikenal sebagai pasar tradisional yang cukup lengkap. Selain kebutuhan dapur, pasar ini juga menawarkan peralatan rumah tangga dan beragam produk lokal dengan harga terjangkau',
                    'gambar' => 'pasar kordon.jpg',
                    'latitude' => -6.954156,
                    'longitude' => -107.639308,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasar');
    }
};
