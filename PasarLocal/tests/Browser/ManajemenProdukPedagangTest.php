<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class ManajemenProdukPedagangTest extends DuskTestCase
{
    use DatabaseMigrations;

    
    /** @test */
    public function dapat_melihat_daftar_produk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pedagang/manajemen-produk')
                   ->assertSee('Manajemen Produk')
                   ->assertSee('Gambar')
                   ->assertSee('Nama Produk')
                   ->assertSee('Kategori')
                   ->assertSee('Stok')
                   ->assertSee('Harga')
                   ->assertSee('Aksi')
                   ->screenshot('lihat-daftar-produk');
        });
    }
    /** @test */
    public function dapat_mencari_produk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pedagang/manajemen-produk')
                   ->type('search', 'Bayam Hijau')
                   ->press('Search')
                   ->waitFor('table')
                   ->screenshot('cari-produk');
        });
    }
    /** @test */
    public function dapat_memfilter_produk_berdasarkan_kategori()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pedagang/manajemen-produk')
                   ->select('kategori')
                   ->press('Search')
                   ->waitFor('table')
                   ->screenshot('filter-kategori');
        });
    }

    /** @test */
    public function dapat_membuka_halaman_tambah_produk()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pedagang/manajemen-produk')
                   ->click('.btn-success')
                   ->assertPathIs('/pedagang/tambah-produk')
                   ->assertSee('Tambah Produk')
                   ->screenshot('halaman-tambah-produk');
        });
    }

    /** @test */
    public function dapat_membuka_halaman_edit_produk()
    {
        $browser->visit('/pedagang/manajemen-produk')
        ->with('.table tbody tr:nth-child(1)', function ($row) {
            $row->click('.btn-warning');})
        ->waitForText('Edit Produk')
        ->assertSee('Edit Produk')
        ->screenshot('halaman-edit-produk');
    }

    /** @test */
    public function dapat_melihat_konfirmasi_hapus_produk()
    {
        $browser->visit('/pedagang/manajemen-produk')
        ->with('.table tbody tr:nth-child(1)', function ($row) {
            $row->click('.btn-danger');
        })
        ->waitForDialog()
        ->assertDialogOpened('Apakah Anda yakin ingin menghapus produk ini?')
        ->screenshot('konfirmasi-hapus-produk');
    }
}
