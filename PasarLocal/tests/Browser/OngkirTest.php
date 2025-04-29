<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OngkirTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group Ongkir
     */
    public function test_create_ongkir(): void
    {
        $this->browse(function (Browser $browser) {
            // Login as admin
            $browser->visit('/')
                    ->type('email', 'pasarlocal382@gmail.com')
                    ->type('password', 'p4sarl0c4l123')
                    ->select('@role-select', 'pedagang')
                    ->assertSelected('@role-select', 'pedagang')
                    ->press('Log in')
                    ->assertPathIs('/admin/manajemen-produk')
                    ->assertSee('Manajemen Ongkir')
                    ->clickLink('Manajemen Ongkir')
                    ->assertPathIs('/admin/ongkir')
                    ->click('@lihat-ongkir-button')
                    ->click('@Tambah-ongkir-button')
                    ->assertVisible('select[name="id_pasar"]')
                    ->select('id_pasar', 'P001')
                    ->assertSelected('select[name="id_pasar"]', 'P001')
                    ->type('@kecamatan', 'Kecamatan A')
                    ->type('@Ongkir', '5000')
                    ->click('@simpan-ongkir');
        });
    }

    public function test_read_ongkir(): void
    {
        $this->browse(function(Browser $browser){
            $browser->visit('/')
                    ->type('email', 'pasarlocal382@gmail.com')
                    ->type('password', 'p4sarl0c4l123')
                    ->select('@role-select', 'pedagang')
                    ->assertSelected('@role-select', 'pedagang')
                    ->press('Log in')
                    ->assertPathIs('/admin/manajemen-produk')
                    ->assertSee('Manajemen Ongkir')
                    ->clickLink('Manajemen Ongkir')
                    ->click('@lihat-ongkir-button');
        });
    }
}
