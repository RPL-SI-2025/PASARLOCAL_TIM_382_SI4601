<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
    }

    public function down()
    {
        Schema::dropIfExists('pasar');
    }
}; 