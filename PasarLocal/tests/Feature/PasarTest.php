<?php

namespace Tests\Feature;

use App\Models\Pasar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PasarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    #[Test]
    public function test_create_pasar_with_valid_data()
    {
        // Data untuk membuat pasar baru
        $pasarData = [
            'nama_pasar' => 'Pasar Baru',
            'lokasi' => 'Jl. Contoh No. 123',
            'deskripsi' => 'Ini adalah pasar baru untuk testing'
        ];

        // Kirim request POST ke endpoint create pasar
        $response = $this->post(route('admin.pasar.store'), $pasarData);

        // Verifikasi response
        $response->assertStatus(302); // Redirect setelah create
        $response->assertRedirect(route('admin.pasar.index'));
        $response->assertSessionHas('success');

        // Verifikasi data tersimpan di database
        $this->assertDatabaseHas('pasar', [
            'nama_pasar' => $pasarData['nama_pasar'],
            'lokasi' => $pasarData['lokasi'],
            'deskripsi' => $pasarData['deskripsi']
        ]);
    }

    #[Test]
    public function test_create_pasar_requires_all_fields()
    {
        // Kirim request POST tanpa data
        $response = $this->post(route('admin.pasar.store'), []);

        // Verifikasi validasi error
        $response->assertSessionHasErrors(['nama_pasar', 'lokasi', 'deskripsi']);
    }

    #[Test]
    public function test_create_pasar_requires_valid_image()
    {
        // Create invalid file (not an image)
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);

        // Data dengan file tidak valid
        $pasarData = [
            'nama_pasar' => 'Pasar Baru',
            'lokasi' => 'Jl. Contoh No. 123',
            'deskripsi' => 'Ini adalah pasar baru untuk testing',
            'gambar' => $invalidFile
        ];

        // Kirim request POST
        $response = $this->post(route('admin.pasar.store'), $pasarData);

        // Verifikasi validasi error untuk gambar
        $response->assertSessionHasErrors('gambar');
    }

    #[Test]
    public function test_user_can_edit_pasar()
    {
        // Buat data pasar
        $pasar = Pasar::factory()->create();

        // Data untuk update pasar
        $updateData = [
            'nama_pasar' => 'Pasar Updated',
            'lokasi' => 'Jl. Baru No. 456',
            'deskripsi' => 'Ini adalah deskripsi yang diupdate'
        ];

        // Kirim request PUT ke endpoint update pasar
        $response = $this->put(route('admin.pasar.update', $pasar->id_pasar), $updateData);

        // Verifikasi response
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.pasar.index'));
        $response->assertSessionHas('success');

        // Verifikasi data terupdate di database
        $this->assertDatabaseHas('pasar', [
            'id_pasar' => $pasar->id_pasar,
            'nama_pasar' => $updateData['nama_pasar'],
            'lokasi' => $updateData['lokasi'],
            'deskripsi' => $updateData['deskripsi']
        ]);
    }

    #[Test]
    public function test_user_can_delete_pasar()
    {
        // Buat data pasar
        $pasar = Pasar::factory()->create();

        // Kirim request DELETE ke endpoint destroy pasar
        $response = $this->delete(route('admin.pasar.destroy', $pasar->id_pasar));

        // Verifikasi response
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.pasar.index'));
        $response->assertSessionHas('success');

        // Verifikasi data terhapus dari database
        $this->assertDatabaseMissing('pasar', [
            'id_pasar' => $pasar->id_pasar
        ]);
    }
} 