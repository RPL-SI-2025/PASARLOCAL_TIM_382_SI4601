<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->timestamps();
        });

        // Insert dummy customer data with plain passwords
        DB::table('customers')->insert([
            [
                'nama_customer' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'customer123',
                'alamat' => 'Jl. Customer No. 1',
                'nomor_telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_customer' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => 'customer123',
                'alamat' => 'Jl. Customer No. 2',
                'nomor_telepon' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}; 