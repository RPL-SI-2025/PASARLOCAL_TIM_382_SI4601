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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ID_review');
            $table->date('tanggal_review');
            $table->text('komentar');
            $table->integer('rating');
            $table->unsignedBigInteger('ID_customer');
            $table->unsignedBigInteger('ID_produk');
            $table->unsignedBigInteger('ID_pelanggan');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};