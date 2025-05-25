<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pasar_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('pasar_id')->references('id_pasar')->on('pasar')->onDelete('cascade');
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('produk_pedagang_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('produk_pedagang_id')->references('id_produk_pedagang')->on('produk_pedagang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
}; 