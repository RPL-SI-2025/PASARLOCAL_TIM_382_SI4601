<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Tester Satu',
            'email' => 'tester@example.com',
            'password' => Hash::make('password123'), // sesuai dengan validasi min:6
        ]);

        // kamu bisa tambahkan user lain jika perlu
        User::create([
            'name' => 'Tester Dua',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
