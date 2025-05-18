<?php

namespace Database\Factories;

use App\Models\Pasar;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasarFactory extends Factory
{
    protected $model = Pasar::class;

    public function definition()
    {
        return [
            'id_pasar' => 'P' . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'nama_pasar' => $this->faker->company,
            'lokasi' => $this->faker->address,
            'deskripsi' => $this->faker->paragraph,
            'gambar' => null
        ];
    }
} 