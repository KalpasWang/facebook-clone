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
              'comment_id' => 1,
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

  public function testBodyIsRequiredToLeaveAComment()
  {
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123]);

    $response = $this->post('/api/posts/'.$post->id.'/comments', [
      'body' => ''
    ])->assertStatus(422);

    $responseString = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('body', $responseString['errors']['meta']);
  }

  public function testPostsAreReturnedWithComments()
  {
    $this->actingAs($user = factory(User::class)->create(), 'api');
    $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);

    $this->post('/api/posts/'.$post->id.'/comments', [
      'body' => 'cool comment!'
    ])->assertStatus(200);

    $comment = Comment::first();
    $response = $this->get('api/posts')
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          [
            'data' => [
              'type' => 'posts',
              'post_id' => $post->id,
              'attributes' => [
                'comments' => [
                  'data' => [
                    [
                      'data' => [
                        'type' => 'comments',
                        'comment_id' => 1,
                        'attributes' => [
                          'commented_by' => [
                            'data' => [
                              'user_id' => $user->id,
                              'attributes' => [
                                'name' => $user->name
                              ]
                            ]
                          ],
                          'body' => $comment->body,
                          'commented_at' => $comment->created_at->diffForHumans(),
                        ]
                      ]
                    ]
                  ],
                  'comments_count' => 1,
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
