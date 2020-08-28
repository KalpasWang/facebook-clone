<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LikeCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'data' => $this->collection,
      'likes_count' => $this->count(),
      'is_user_likes_post' => $this->collection->every(function($value, $key){
        if(is_array($value)) {
          return $value['user_id'] == auth()->user()->id;
        }
        return false;
      }),
      'links' => [
        'self' => url('/posts')
      ]
    ];
  }
}
