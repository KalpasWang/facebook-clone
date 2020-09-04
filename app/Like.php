<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Like extends Model
{
  public $primaryKey = 'id';
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
