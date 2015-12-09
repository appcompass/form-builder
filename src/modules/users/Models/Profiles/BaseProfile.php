<?php

namespace P3in\Profiles;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;

class BaseProfile extends Model
{

  public $table = 'profiles';

  public $fillable = [
    'id',
    'model',
    'active',
    'data',
    'user_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

}
