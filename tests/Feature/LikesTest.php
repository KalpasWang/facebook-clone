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
              'type' => 'likes',
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

  public function testPostsAreReturnedWithLikes()
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');

    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);

    $this->post('api/posts/'.$post->id.'/likes')->assertStatus(200);

    $response = $this->get('api/posts')
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $post->id,
              'attributes' => [
                'likes' => [
                  'data' => [
                    [
                      'data' => [
                        'type' => 'likes',
                        'likes_id' => 1,
                        'attributes' => []
                      ]
                    ]
                  ],
                  'likes_count' => 1,
                  // 'is_user_likes_post' => true,
                ]
              ]
            ]
          ],
        ],
        'links' => [
          'self' => url('/posts')
        ]
      ]);
  }
}