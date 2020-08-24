<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class LikesTest extends TestCase
{
  use RefreshDatabase;

  public function testAUserCanLikeAPost()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123]);

    $response = $this->post('/api/posts/'.$post->id.'/likes')
      ->assertStatus(200);

    $this->assertCount(1, $user->likedPosts);
    $response->assertJson([
        'data' => [
          [        
            'data' => [
              'types' => 'likes',
              'likes_id' => 1,
              'attributes' => []
            ],
            'links' => [
              'self' => url('/posts/123')
            ]
          ]
        ],
        'links' => [
          'self' => url('/posts'),
        ]
      ]);
  }
}