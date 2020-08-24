<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasAPITokens;
use App\Post;

class User extends Authenticatable
{
  use Notifiable, HasAPITokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  public function friends()
  {
    return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
  }

  public function posts() 
  {
    return $this->hasMany(Post::class);
  }

  public function likedPosts()
  {
    return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
  }
}
