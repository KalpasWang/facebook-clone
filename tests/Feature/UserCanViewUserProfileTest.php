<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserCanViewUserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanAccessProfile()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(\App\Post::class, 2)->create();

        $response = $this->get('/api/users/'.$user->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'user_id' => $user->id,
                    'attributes' => [
                        'name' => $user->name,
                    ]
                ],
                'links' => [
                    'self' => url('/users/'.$user->id),
                ]
            ]);
    }
}
