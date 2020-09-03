<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use App\Http\Resources\LikeCollection;

class PostLikesController extends Controller
{
  public function store(Post $post)
  {
    // $post->likes()->toggle(auth()->user());
    $model = $post->likes()->where('user_id', auth()->user()->id)->first();
    if($model)
    {
      $model->delete();
      $model->save();
    }
    else
    {
      $like = Like::create([
        'user_id' => auth()->user()->id,
        'post_id' => $post->id
      ]);
      echo ' like ID '.$like->id;
    }

    return new LikeCollection($post->likes);
  }
}
