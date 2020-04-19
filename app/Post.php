<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ReverseScope;
use App\User;

class Post extends Model
{
  protected $table = 'posts';
  public $primaryKey = 'id';
  public $timestamps = true;
  protected $guarded = [];

  protected static function boot()
  {
      parent::boot();

      static::addGlobalScope(new ReverseScope());
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
