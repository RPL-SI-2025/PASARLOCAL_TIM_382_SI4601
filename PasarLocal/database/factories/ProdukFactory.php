<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'nama_produk' => $this->faker->words(2, true),
            'id_kategori' => KategoriProduk::factory(),
            'deskripsi_produk' => $this->faker->sentence(),
            'gambar' => 'kecipir.jpg', // bisa dummy
        ];
    }
}
