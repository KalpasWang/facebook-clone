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
    // $this->withoutExceptionHandling();

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
        ]
      ],
      'links' => [
        'self' => url('/users/'.$anotherUser->id),
      ]
    ]);
  }
} 
