<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tes halaman edit profile.
     *
     * @return void
     */
    public function test_user_can_see_edit_profile_page()
    {
        // Buat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Akses halaman edit profile
        $response = $this->get('/profile/edit'); // Sesuaikan dengan rute edit profile di aplikasi kamu

        // Pastikan halaman dapat diakses
        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
    }

    /**
     * Tes update profile.
     *
     * @return void
     */
    public function test_user_can_update_profile()
    {
        // Buat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Data baru untuk profil
        $data = [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
            'phone' => '08123456789',
            'address' => 'New Address',
        ];

        // Lakukan request untuk memperbarui profil
        $response = $this->put('/profile', $data); // Sesuaikan dengan rute update profile di aplikasi kamu

        // Pastikan redirect ke halaman yang benar
        $response->assertRedirect();

        // Pastikan data berhasil diperbarui di database
        $this->assertDatabaseHas('users', [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
            'phone' => '08123456789',
            'address' => 'New Address',
        ]);
    }
}
