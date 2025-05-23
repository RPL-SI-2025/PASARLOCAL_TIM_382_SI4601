<?php

namespace Tests\Browser;

use App\Models\KategoriProduk;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class KategoriProdukTest extends DuskTestCase
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

    /** @group kategori */
    public function test_admin_dapat_melihat_halaman_kategori()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsPedagang($browser);
            $browser->assertSee('Manajemen Kategori')
                    ->clickLink('Manajemen Kategori')
                    ->assertPathIs('/admin/kategori-produk')
                    ->assertSee('Manajemen Kategori Produk');
        });
    }

    /** @group kategori */
    public function test_admin_dapat_menambahkan_kategori_baru()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsPedagang($browser);
            $browser->visit('/admin/kategori-produk')
                    ->click('@tambah-kategori')
                    ->type('nama_kategori', ' Kacang')
                    ->attach('gambar', base_path('tests/Browser/files/kacang.jpg'))
                    ->press('Simpan')
                    ->assertPathIs('/admin/kategori-produk')
                    ->assertSee('Manajemen Kategori Produk');
        });
    }

    /** @group kategori */
    public function test_admin_dapat_mengedit_kategori()
    {
        $kategori = KategoriProduk::create([
            'nama_kategori' => 'Kacang',
            'gambar' => 'kacang.jpg'
        ]);

        $this->browse(function (Browser $browser) use ($kategori) {
            $this->loginAsPedagang($browser);
            $browser->visit('/admin/kategori-produk')
                    ->click("@edit-{$kategori->id}")
                    ->type('nama_kategori', 'Kacang Baru')
                    ->attach('gambar', base_path('tests/Browser/files/kacang.jpg'))
                    ->press('Update')
                    ->assertPathIs('/admin/kategori-produk')
                    ->assertSee('Manajemen Kategori Produk');
        });
    }

    /** @group kategori */
/** @group kategori */
public function test_admin_dapat_menghapus_kategori_sayur()
{
    $kategori = \App\Models\KategoriProduk::where('nama_kategori', 'Sayur')->first();

    if (!$kategori) {
        $this->fail('Kategori "Sayur" tidak ditemukan di database.');
        return;
    }

    $this->browse(function (Browser $browser) use ($kategori) {
        $browser->visit('/admin/kategori-produk')
                ->assertSee('Sayur')
                ->press('@hapus-' . $kategori->id)
                ->acceptDialog()
                ->pause(1000)
                ->assertDontSee('Sayur');
    });
}

}
