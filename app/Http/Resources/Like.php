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
          'user_id' => (int)$this->pivot->user_id,
          'post_id' => (int)$this->pivot->post_id,
          'attributes' => [],
        ],
        'links' => [
          'self' => url('/posts/'.$this->pivot->post_id)
        ]
      ];
    }
}
