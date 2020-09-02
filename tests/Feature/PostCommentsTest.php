<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;
use App\Comment;

class PostCommentsTest extends TestCase
{
  use RefreshDatabase;

  public function testAUserCanCommentAPost()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123]);

    $response = $this->post('/api/posts/'.$post->id.'/comments', [
      'body' => 'cool comment!'
    ])->assertStatus(200);

    $comment = Comment::first();
    $this->assertCount(1, Comment::all());
    $this->assertEquals($comment->user_id, $user->id);
    $this->assertEquals($comment->post_id, $post->id);
    $this->assertEquals($comment->body, 'cool comment!');
    $response->assertJson([
        'data' => [
          [        
            'data' => [
              'type' => 'comments',
              'comments_id' => 1,
              'attributes' => [
                'commented_by' => [
                  'data' => [
                    'user_id' => $user->id,
                    'attributes' => [
                      'name' => $user->name
                    ]
                  ]
                ],
                'body' => 'cool comment!',
                'commented_at' => $comment->created_at->diffForHumans(),
              ]
            ],
            'links' => [
              'self' => url('/posts/123')
            ]
          ]
        ],
        'comments_count' => 1,
        'links' => [
          'self' => url('/posts'),
        ]
      ]);
  }
}
