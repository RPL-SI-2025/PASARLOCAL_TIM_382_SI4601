<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testPostCanBeCreated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => 'Judul Postingan',
            'body' => 'Isi postingan',
        ];

        $response = $this->post('/posts', $postData);

        $response->assertStatus(302); // Atau status lain yang sesuai
        $this->assertDatabaseHas('posts', [
            'title' => 'Judul Postingan',
            'body' => 'Isi postingan',
            'user_id' => $user->id,
        ]);
    }

    public function testPostBelongsToUser()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $post->user->id);
    }
}
