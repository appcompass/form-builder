<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

  protected $table = 'settings';

  protected $fillable = [
    'data'
  ];

  public function settingable()
  {
    return $this->morphTo();
  }

}