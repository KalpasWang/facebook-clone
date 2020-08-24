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
            'types' => 'likes',
            'likes_id' => $this->id,
            'attributes' => [],
          ],
          'links' => [
            'self' => url('/posts/'.$this->pivot->post_id)
          ]
        ];
    }
}
