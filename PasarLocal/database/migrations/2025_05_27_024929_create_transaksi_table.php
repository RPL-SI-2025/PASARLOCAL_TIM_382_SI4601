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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasar');
            $table->unsignedBigInteger('id_produk_pedagang');
            $table->unsignedBigInteger('id_user');
            $table->integer('quantity');
            $table->text('ulasan')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
            $table->foreign('id_produk_pedagang')->references('id_produk_pedagang')->on('produk_pedagang')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('transaksis')->insert([
            ['id_pasar' => 1,
            'id_produk_pedagang' => 1,
            'id_user' => 2,
            'quantity' => 2,
            'ulasan' => 'bagus enak sekali',
            'created_at'     => now(),
            'updated_at'     => now(),],
            ['id_pasar' => 1,
            'id_produk_pedagang' => 2,
            'id_user' => 2,
            'quantity' => 2,
            'ulasan' => 'bagus enak sekali',
            'created_at'     => now(),
            'updated_at'     => now(),],
        ]);
    }


    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
