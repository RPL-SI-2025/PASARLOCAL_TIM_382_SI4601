<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('diskons', function (Blueprint $table) {
            $table->id('id_diskon');
            $table->string('kode_diskon')->unique();
            $table->string('nama_diskon');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_diskon', ['amount', 'shipping']);
            $table->decimal('nilai_diskon', 10, 2);
            $table->decimal('max_diskon', 10, 2)->nullable();
            $table->decimal('min_pembelian', 10, 2)->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_berakhir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
}; 