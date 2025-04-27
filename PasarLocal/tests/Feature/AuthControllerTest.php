<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Registered successfully']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'login@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged in successfully']);
    }

    public function test_login_fails_with_wrong_credentials()
    {
        $user = User::factory()->create([
            'email' => 'fail@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'fail@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['error' => 'Invalid credentials']);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->postJson('/logout')
             ->assertStatus(200)
             ->assertJson(['message' => 'Logged out successfully']);
    }
}
