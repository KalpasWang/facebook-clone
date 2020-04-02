<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class PostToTimelineTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function a_user_can_post_a_text_post()
    {
      $this->actingAs($user = factory(User::class)->create(), 'api');

      $response = $this->post('/api/posts', [])
    }
}
