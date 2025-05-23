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
        Schema::create('produk_pedagang', function (Blueprint $table) {
            $table->id('id_produk_pedagang');
            $table->unsignedBigInteger('id_pedagang');
            $table->unsignedBigInteger('id_produk');
            $table->integer('stok');
            $table->integer('jumlah_satuan')->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('foto_produk');
            $table->timestamps();

            $table->foreign('id_pedagang')->references('id_pedagang')->on('pedagang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_pedagang');
    }
};
