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

  public function testAUserCanFetchPostsForProfile()
  {
    $this->withoutExceptionHandling();
    
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(\App\Post::class)->create(['user_id' => $user->id]);

    $response = $this->get('/api/users/'.$user->id.'/posts');

    $response->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $post->id,
              'attributes' => [
                'body' => $post->body,
                'image' => $post->image,
                'posted_at' => $post->created_at->diffForHumans(),
                'posted_by' => [
                  'data' => [
                    'attributes' => [
                      'name' => $user->name,
                    ]
                  ]
                ]
              ]
            ],
            'links' => [
              'self' => url('/posts/'.$post->id),
            ]
          ],
        ]
      ]);
  }
}
