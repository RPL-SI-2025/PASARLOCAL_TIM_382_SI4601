<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HitungOngkirTest extends TestCase
{
    /**
     * TC01 - Hitung Ongkir Sukses
     */
    public function test_hitung_ongkir_sukses()
    {
        // Simulasi input data
        $payload = [
            'asal' => 'Bandung',
            'tujuan' => 'Jakarta',
            'berat' => 1000, // berat dalam gram
        ];

        // Panggil endpoint POST /cek-ongkir
        $response = $this->post('/cek-ongkir', $payload);

        // Pastikan response sukses
        $response->assertStatus(200);

        // Pastikan ada key 'ongkir' di JSON
        $response->assertJsonStructure([
            'ongkir',
        ]);

        // (Opsional) Pastikan ongkir tidak null atau kosong
        $this->assertNotNull($response->json('ongkir'));
    }
}
