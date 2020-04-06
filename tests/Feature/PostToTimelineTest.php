<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class PostToTimelineTest extends TestCase
{

  use RefreshDatabase;

  
  public function testUserCanPostTextPost()
  {
    $this->withoutExceptionHandling();
    $this->actingAs($user = factory(User::class)->create(), 'api');

    $response = $this->post('/api/posts', [
      'data' => [
        'type' => 'posts',
        'attributes' => [
          'body' => 'Testing Body'
        ]
      ]
    ]);

    $post = Post::first();

    $this->assertCount(1, Post::all());
    $this->assertEquals($user->id, $post->user_id);
    $this->assertEquals('Testing Body', $post->body);
    $response->assertStatus(201)
      ->assertJson([
        'data' => [
          'type' => 'posts',
          'post_id' => $post->id,
          'attributes' => [
            'body' => $post->body,
          ]
        ],
        'links' => [
          'self' => url('/posts/'.$post->id),
        ]
      ]);
  }
}
