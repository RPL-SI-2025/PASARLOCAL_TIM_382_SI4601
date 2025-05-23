<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditProfileTest extends DuskTestCase
{
    /**
     * @group edit-profile
     */
    public function test_user_can_update_profile(): void
    {
        $this->browse(function (Browser $browser) {
            // Cari user pertama, kalau tidak ada buat baru
            $user = User::first() ?? User::factory()->create([
                'password' => Hash::make('password')
            ]);

            $browser->loginAs(User::find(1)) // atau user lain yang valid
                    ->visit('http://127.0.0.1:8000/profile/edit')
                    ->waitForText('Edit Profil', 5) // tunggu sampai teks muncul
                    ->assertSee('Edit Profil')
                    ->type('name', 'Nama Baru')             // JANGAN pakai input[name="name"], cukup 'name' saja
                    ->type('email', 'newemail@example.com')
                    ->type('phone', '08123456789')
                    ->type('address', 'Alamat Baru')
                    ->press('Perbarui Profil')
                    ->assertPathIs('/profile');            // Setelah update, cek redirection
        });
    }
    public function test_update_profile_fails_when_name_is_empty()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('http://127.0.0.1:8000/profile/edit')
                    ->assertPathIs('/profile/edit')
                    ->assertSee('Edit Profil')
                    ->type('name', '') // Kosongin nama
                    ->type('email', 'newemail@example.com')
                    ->type('phone', '08123456789')
                    ->type('address', 'Alamat Baru')
                    ->press('Simpan')
                    ->assertPathIs('/profile/edit')
                    ->assertSee('The name field is required'); // Pastikan error muncul
        });
    }
}
