<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Like extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'data' => [
          'type' => 'likes',
          'like_id' => $this->id,
          'user_id' => $this->user_id,
          'post_id' => $this->post_id,
          'attributes' => [],
        ],
        'links' => [
          'self' => url('/posts/'.$this->post_id)
        ]
      ];
    }
}
