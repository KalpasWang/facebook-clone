<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Friend;

class RetrievePostsTest extends TestCase
{
  use RefreshDatabase;

  public function testAUserCanRetrievePosts() 
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $anotherUser = factory(User::class)->create();

    $posts = factory(\App\Post::class, 2)->create(['user_id' => $user->id]);
    $friendPost = factory(\App\Post::class, 1)->create(['user_id' => $anotherUser->id]);

    Friend::create([
      'user_id' => $user->id,
      'friend_id' => $anotherUser->id,
      'confirmed_at' => now(),
      'status' => 1,
    ]);

    $response = $this->get('/api/posts');

    $response->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $friendPost->last()->id,
              'attributes' => [
                  'body' => $friendPost->last()->body,
                  'image' => $friendPost->last()->image,
                  'posted_at' => $friendPost->last()->created_at->diffForHumans(),
              ]
            ]
          ],
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $posts->last()->id,
              'attributes' => [
                  'body' => $posts->last()->body,
                  'image' => $posts->last()->image,
                  'posted_at' => $posts->last()->created_at->diffForHumans(),
              ]
            ]
          ],
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $posts->first()->id,
              'attributes' => [
                  'body' => $posts->first()->body,
                  'image' => $posts->first()->image,
                  'posted_at' => $posts->first()->created_at->diffForHumans(),
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
