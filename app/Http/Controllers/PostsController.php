<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use App\Friend;
use App\Post;

class PostsController extends Controller
{
  public function index()
  {
    $friendships = Friend::authUserFriendships();
    
    if($friendships->isEmpty())
    {
      return new PostCollection(request()->user()->posts);
    }

    return new PostCollection(
      Post::whereIn('user_id', [$friendships->pluck('user_id'), $friendships->pluck('friend_id')])
        ->get());
  }

  public function store() {
    $data = request()->validate([
      'body' => 'required'
    ]);

    // dd($data);

    $post = request()->user()->posts()->create($data);

    return new PostResource($post);
  }
}
