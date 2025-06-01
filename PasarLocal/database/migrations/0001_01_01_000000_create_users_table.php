<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'pedagang', 'customer'])->default('customer');
            $table->string('alamat')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->rememberToken();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        // Insert default admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'pasarlocal382@gmail.com',
            'password' => Hash::make('p4sarl0c4l123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            'last_seen_at' => now()
        ]);

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
