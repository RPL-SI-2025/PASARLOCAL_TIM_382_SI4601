<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\KategoriProduk;

class ManajemenKategoriProdukTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_dapat_melihat_daftar_kategori()
    {
        KategoriProduk::factory()->create(['nama_kategori' => 'Sayur']);
        KategoriProduk::factory()->create(['nama_kategori' => 'Buah-buahan']);

        $response = $this->get('/admin/kategori-produk');

        $response->assertStatus(200);
        $response->assertSee('Sayur');
        $response->assertSee('Buah-buahan');
    }

    /** @test */
    public function user_dapat_menambahkan_kategori_baru()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('elektronik.jpg');

        $response = $this->post('/admin/kategori-produk', [
            'nama_kategori' => 'Elektronik',
            'gambar' => $file,
        ]);

        $response->assertRedirect('/admin/kategori-produk');

        $this->assertDatabaseHas('kategori_produk', [
            'nama_kategori' => 'Elektronik',
        ]);
    }

    /** @test */
    public function user_dapat_mengedit_kategori()
    {
        $kategori = KategoriProduk::factory()->create(['nama_kategori' => 'Daging Ayam']);

        $response = $this->put("/admin/kategori-produk/{$kategori->id}", [
            'nama_kategori' => 'Daging Bebek',
        ]);

        $response->assertRedirect('/admin/kategori-produk');

        $this->assertDatabaseHas('kategori_produk', [
            'id' => $kategori->id,
            'nama_kategori' => 'Daging Bebek',
        ]);
    }

    /** @test */
    public function user_dapat_menghapus_kategori()
    {
        $kategori = KategoriProduk::factory()->create(['nama_kategori' => 'Buah Lokal']);

        $response = $this->delete("/admin/kategori-produk/{$kategori->id}");

        $response->assertRedirect('/admin/kategori-produk');

        $this->assertDatabaseMissing('kategori_produk', [
            'id' => $kategori->id,
        ]);
    }
}
