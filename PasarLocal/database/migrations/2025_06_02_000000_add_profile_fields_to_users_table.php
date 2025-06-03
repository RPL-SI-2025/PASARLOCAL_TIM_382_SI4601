<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kecamatan')->nullable()->after('alamat');
            $table->string('nama_toko')->nullable()->after('name');
            $table->string('nama_pemilik')->nullable()->after('nama_toko');
            $table->string('profile_image')->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'nama_toko', 'nama_pemilik', 'profile_image']);
        });
    }
};
