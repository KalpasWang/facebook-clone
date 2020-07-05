<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
