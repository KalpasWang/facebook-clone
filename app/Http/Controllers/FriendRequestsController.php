<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Http\Resources\Friend as FriendResource;

class FriendRequestsController extends Controller
{
  public function store()
  {
    $data = request()->validate([
      'friend_id' => ''
    ]);

    User::find($data['friend_id'])
      ->friends()->attach(auth()->user());

    return new FriendResource(
      Friend::where('user_id', auth()->user()->id)
      ->where('friend_id', $data['friend_id'])
      ->first()
    );
  }
}
