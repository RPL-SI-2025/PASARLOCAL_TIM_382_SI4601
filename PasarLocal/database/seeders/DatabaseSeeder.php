<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class, // pastikan user dibuat dulu
            PedagangSeeder::class,
            TransaksiSeeder::class, // seed transaksi setelah user dan pedagang
        ]);
    }
    public function ran(): void
{
    $this->call([
        UserSeeder::class,
    ]);
}
}
