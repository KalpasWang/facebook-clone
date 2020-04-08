<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostsController extends Controller
{
    public function store() {
      $data = request()->validate([
        'data.attributes.body' => 'required'
      ]);

      // dd($data);

      $post = request()->user()->posts()->create($data['data']['attributes']);

      // return response([
      //   'data' => [
      //     'type' => 'posts',
      //     'post_id' => $post->id,
      //     'attributes' => [
      //       'body' => $post->body,
      //     ]
      //   ],
      //   'links' => [
      //     'self' => url('/posts/'.$post->id),
      //   ]
      // ], 201);

      return new PostResource($post);
    }
}
