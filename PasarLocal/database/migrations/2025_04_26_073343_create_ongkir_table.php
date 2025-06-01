<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ongkir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasar');
            $table->string('kecamatan_tujuan');
            $table->integer('ongkir');
            $table->timestamps();

            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
        });

        //Dummy Ongkir
        DB::table('ongkir')->insert([
            [
                'id_pasar' => 1,
                'kecamatan_tujuan' => 'bojongsoang',
                'ongkir' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasar' => 2,
                'kecamatan_tujuan' => 'ciwidey',
                'ongkir' => 30000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasar' => 3,
                'kecamatan_tujuan' => 'Antapani',
                'ongkir' => 10000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pasar' => 4,
                'kecamatan_tujuan' => 'Andir',
                'ongkir' => 50000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ongkir');
    }
};
