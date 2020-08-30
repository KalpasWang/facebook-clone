<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\LikeCollection;

class PostLikesController extends Controller
{
  public function store(Post $post)
  {
    $post->likes()->toggle(auth()->user()->id);
    return new LikeCollection($post->likes);
  }
}