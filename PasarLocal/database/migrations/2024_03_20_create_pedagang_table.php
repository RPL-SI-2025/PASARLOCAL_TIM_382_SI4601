<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedagang', function (Blueprint $table) {
            $table->string('id_pedagang', 10)->primary();
            $table->string('id_pasar', 10);
            $table->string('nama_pedagang', 100);
            $table->string('lokasi_toko', 100);
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedagang');
    }
}; 