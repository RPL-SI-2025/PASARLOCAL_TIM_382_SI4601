<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriProdukFactory extends Factory
{
    protected $model = KategoriProduk::class;

    public function definition()
    {
        return [
            'nama_kategori' => $this->faker->word(),
            'gambar' => 'elektronik.jpg'
        ];
    }
}
