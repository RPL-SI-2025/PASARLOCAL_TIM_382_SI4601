<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ongkir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasar');
            $table->string('kecamatan_tujuan');
            $table->integer('ongkir');
            $table->timestamps();
            $table->foreign('id_pasar')
                ->references('id_pasar')
                ->on('pasar')
                ->onDelete('cascade'); // opsional: hapus ongkir jika pasar dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ongkir');
    }
};
