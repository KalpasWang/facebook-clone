<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class RetrievePostsTest extends TestCase
{
  use RefreshDatabase;

  public function testAUserCanRetrievePosts() 
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $posts = factory(\App\Post::class, 2)->create(['user_id' => $user->id]);

    $response = $this->get('/api/posts');

    $response->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $posts->last()->id,
              'attributes' => [
                  'body' => $posts->last()->body,
              ]
            ]
          ],
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $posts->first()->id,
              'attributes' => [
                  'body' => $posts->first()->body,
              ]
            ]
          ],
        ],
        'links' => [
          'self' => url('/posts')
        ]
      ]);
  }

  public function testAUserCanOnlyRetriveTheirPosts() 
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $posts = factory(\App\Post::class)->create();

    $response = $this->get('/api/posts');

    $response->assertStatus(200)
      ->assertExactJson([
        'data' => [],
        'links' => [
          'self' => url('/posts')
        ]
      ]);
  }
}
