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
        // database/migrations/xxxx_create_shipping_costs_table.php
        Schema::create('shipping_costs', function (Blueprint $table) {
            $table->id();
            $table->string('destination'); // contoh: "Kota A", "Kecamatan B"
            $table->integer('distance_km');
            $table->integer('cost_per_km'); // misal: 2000
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_costs');
    }
};
