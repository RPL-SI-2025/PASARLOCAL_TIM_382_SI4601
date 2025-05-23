<?php

namespace Tests\Browser;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManajemenProdukTest extends DuskTestCase
{
    protected function loginAsPedagang(Browser $browser)
    {
        $browser->visit('/')
                ->type('email', 'pasarlocal382@gmail.com')
                ->type('password', 'p4sarl0c4l123')
                ->select('@role-select', 'pedagang')
                ->assertSelected('@role-select', 'pedagang')
                ->press('Log in')
                ->assertPathIs('/admin/manajemen-produk');
    }

    /**
     * Test untuk menambah produk baru
     * @group produk
     */
    public function test_user_bisa_menambah_produk_baru()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsPedagang($browser);
    
            $browser->visit('/admin/manajemen-produk')
            ->click('@tambah-produk')
            ->pause(500)
            ->type('nama_produk', 'garam')
            ->click('#id_kategori')
            ->pause(500)
            ->select('id_kategori', 'Rempah & Bumbu')
            ->type('deskripsi_produk', 'garam himalaya')
            ->attach('gambar', base_path('tests/Browser/files/garam.jpg'))
            ->type('id', '6')
            ->press('Simpan')
            ->assertPathIs('/admin/manajemen-produk')
            ->assertSee('garam');
        
        

    
        });
    }

    /**
     * Test untuk edit produk
     * @group produk
     */
    public function test_user_bisa_edit_produk()
    {
        $kategori = KategoriProduk::factory()->create();
        $produk = Produk::factory()->create(['id_kategori' => $kategori->id]);

        $this->browse(function (Browser $browser) use ($produk, $kategori) {
            $this->loginAsPedagang($browser);
            $browser->visit('/admin/manajemen-produk/' . $produk->id . '/edit')
                ->type('#nama_produk', 'Produk Edit Test')
                // Pastikan ID kategori sudah benar dan konsisten
                ->select('#kategori_id', $kategori->id) // Perbaiki jika nama selektor berbeda
                ->type('#deskripsi_produk', 'Ini deskripsi produk edit test')
                ->attach('#gambar', __DIR__.'/files/garam.jpg') // Periksa jalur file
                ->press('Update')
                ->assertPathIs('/admin/manajemen-produk')
                ->assertSee('Produk Edit Test');
        });
    }

    /**
     * Test untuk menghapus produk
     * @group produk
     */
    public function test_user_bisa_menghapus_produk()
    {
        $kategori = KategoriProduk::factory()->create();
        $produk = Produk::factory()->create(['id_kategori' => $kategori->id]);

        $this->browse(function (Browser $browser) use ($produk) {
            $this->loginAsPedagang($browser);
            $browser->visit('/admin/manajemen-produk')
                ->press('@hapus-produk-' . $produk->id)
                ->assertDontSee($produk->nama_produk);
        });
    }
}
