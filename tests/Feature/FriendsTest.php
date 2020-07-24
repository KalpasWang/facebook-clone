<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class FriendsTest extends TestCase
{
  use RefreshDatabase;

  public function testAUserCanSendAFriendRequest()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();

    $response = $this->post('/api/friend-request', [
        'friend_id' => $anotherUser->id,
    ])->assertStatus(200);

    $friendRequest = \App\Friend::first();
    $this->assertNotNull($friendRequest);
    $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
    $this->assertEquals($user->id, $friendRequest->user_id);
    $response->assertJson([
      'data' => [
        'type' => 'friend-request',
        'friend_request_id' => $friendRequest->id,
        'attributes' => [
          'confirmed_at' => null,
        ]
      ],
      'links' => [
        'self' => url('/users/'.$anotherUser->id),
      ]
    ]);
  }
  
  public function testOnlyValidUsersCanBeFriendRequested()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');

    $response = $this->post('/api/friend-request', [
        'friend_id' => 1111,
    ])->assertStatus(404);

    $this->assertNull(\App\Friend::first());

    $response->assertJson([
      'errors' => [
        'code' => 404,
        'title' => 'User Not Found',
        'detail' => 'Unable to locate the user with the given information.',
      ]
    ]);
  }

  public function testFriendRequestsCanBeAccepted()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    
    $response = $this->post('/api/friend-request', [
      'friend_id' => $anotherUser->id,
    ])->assertStatus(200);
      
    $this->actingAs($anotherUser, 'api');

    $response = $this->post('/api/friend-request-response', [
      'user_id' => $user->id,
      'status' => 1
    ])->assertStatus(200);

    $friendRequest = \App\Friend::first();
    $this->assertNotNull($friendRequest->confirmed_at);
    $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);
    $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);
    $this->assertEquals($friendRequest->status, 1);
    $response->assertJson([
      'data' => [
        'type' => 'friend-request',
        'friend_request_id' => $friendRequest->id,
        'attributes' => [
          'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
          'friend_id' => $friendRequest->friend_id,
          'user_id' => $friendRequest->user_id
        ]
      ],
      'links' => [
        'self' => url('/users/'.$anotherUser->id),
      ]
    ]);
  }

  public function testFriendRequestsCanBeIgnored()
  {
    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    
    $response = $this->post('/api/friend-request', [
      'friend_id' => $anotherUser->id,
    ])->assertStatus(200);
      
    $this->actingAs($anotherUser, 'api');

    $response = $this->delete('/api/friend-request-response/delete', [
      'user_id' => $user->id,
    ])->assertStatus(204);

    $friendRequest = \App\Friend::first();
    $this->assertNull($friendRequest);
    $response->assertNoContent();
  }

  public function testOnlyValidFriendRequestsCanBeAccepted()
  {
    $anotherUser = factory(\App\User::class)->create();
    $this->actingAs($anotherUser, 'api');

    $response = $this->post('/api/friend-request-response', [
      'user_id' => 123,
      'status' => 1
    ])->assertStatus(404);

    $this->assertNull(\App\Friend::first());
    $response->assertJson([
      'errors' => [
        'code' => 404,
        'title' => 'Friend Request Not Found',
        'detail' => 'Unable to locate the friend request with the given information.',
      ]
    ]);
  }

  public function testOnlyRecipientCanAcceptAFriendRequest()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    $this->post('/api/friend-request', [
        'friend_id' => $anotherUser->id,
      ])->assertStatus(200);

    $thirdUser = factory(\App\User::class)->create();
    $response = $this->actingAs($thirdUser, 'api')
      ->post('/api/friend-request-response', [
        'user_id' => $user->id,
        'status' => 1,
      ])->assertStatus(404);

    $friendRequest = \App\Friend::first();
    $this->assertNull($friendRequest->confirmed_at);
    $this->assertNull($friendRequest->status);
    $response->assertJson([
      'errors' => [
        'code' => 404,
        'title' => 'Friend Request Not Found',
        'detail' => 'Unable to locate the friend request with the given information.',
      ]
    ]);
  }

  public function testOnlyRecipientCanIgnoreAFriendRequest()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    $this->post('/api/friend-request', [
        'friend_id' => $anotherUser->id,
      ])->assertStatus(200);

    $thirdUser = factory(\App\User::class)->create();
    $response = $this->actingAs($thirdUser, 'api')
      ->delete('/api/friend-request-response/delete', [
        'user_id' => $user->id,
      ])->assertStatus(404);

    $friendRequest = \App\Friend::first();
    $this->assertNotNull($friendRequest);
    $this->assertNull($friendRequest->confirmed_at);
    $this->assertNull($friendRequest->status);
    $response->assertJson([
      'errors' => [
        'code' => 404,
        'title' => 'Friend Request Not Found',
        'detail' => 'Unable to locate the friend request with the given information.',
      ]
    ]);
  }

  public function testAfriendIdIsRequiredForFriendRequest()
  {
    $response = $this->actingAs($user = factory(\App\User::class)->create(), 'api')
      ->post('/api/friend-request', [
          'friend_id' => '',
      ])->assertStatus(422);

    $responseString = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('friend_id', $responseString['errors']['meta']);
  }

  public function testAUserIdAndStatusIsRequiredForFriendRequestResponses()
  {
    $response = $this->actingAs($user = factory(\App\User::class)->create(), 'api')
      ->post('/api/friend-request-response', [
        'user_id' => '',
        'status' => '',
      ])->assertStatus(422);

    $responseString = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
    $this->assertArrayHasKey('status', $responseString['errors']['meta']);
  }

  public function testAUserIdIsRequiredForIgnoringAFriendRequestResponses()
  {
    $response = $this->actingAs($user = factory(\App\User::class)->create(), 'api')
      ->delete('/api/friend-request-response/delete', [
        'user_id' => '',
      ])->assertStatus(422);

    $responseString = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
  }

  public function testAFriendshipIsRetrievedWhenFetchingUserProfile()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    $friendRequest = \App\Friend::create([
      'user_id' => $user->id,
      'friend_id' => $anotherUser->id,
      'confirmed_at' => now()->subDay(),
      'status' => 1,
    ]);

    $this->get('/api/users/'.$anotherUser->id)
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'attributes' => [
            'friendship' => [
              'data' => [
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                  'confirmed_at' => '1 day ago',
                ]
              ]
            ]
          ]
        ],
      ]);
  }

  public function testAnInverseFriendshipIsRetrievedWhenFetchingUserProfile()
  {
    $this->actingAs($user = factory(\App\User::class)->create(), 'api');
    $anotherUser = factory(\App\User::class)->create();
    $friendRequest = \App\Friend::create([
      'user_id' => $anotherUser->id,
      'friend_id' => $user->id,
      'confirmed_at' => now()->subDay(),
      'status' => 1,
    ]);

    $this->get('/api/users/'.$anotherUser->id)
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'attributes' => [
            'friendship' => [
              'data' => [
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                  'confirmed_at' => '1 day ago',
                ]
              ]
            ]
          ]
        ],
      ]);
  }
} 
