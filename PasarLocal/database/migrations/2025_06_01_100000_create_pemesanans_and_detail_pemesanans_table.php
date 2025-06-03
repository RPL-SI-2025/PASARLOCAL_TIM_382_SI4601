<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('ongkir_id')->nullable();
            $table->integer('total_harga');
            $table->string('metode_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status')->default('belum proses');
            $table->string('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('ongkir_id')->references('id')->on('ongkir')->onDelete('cascade');
        });

        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemesanan_id');
            $table->unsignedBigInteger('produk_pedagang_id');
            $table->unsignedBigInteger('id_pasar');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->timestamps();
            $table->foreign('pemesanan_id')->references('id')->on('pemesanans')->onDelete('cascade');
            $table->foreign('produk_pedagang_id')->references('id_produk_pedagang')->on('produk_pedagang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanans');
        Schema::dropIfExists('pemesanans');
    }
};
