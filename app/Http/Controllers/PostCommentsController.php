<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\CommentCollection;

class PostCommentsController extends Controller
{
  public function store(Post $post)
  {
    $data = request()->validate([
      'body' => ''
    ]);

    $post->comments()->create(array_merge($data, [
      'user_id' => auth()->user()->id
    ]));

    return new CommentCollection($post->comments);
  }
}
