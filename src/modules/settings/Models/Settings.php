<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\ModularBaseModel;

class Settings extends ModularBaseModel
{

  protected $table = 'settings';

  protected $fillable = [
    'data'
  ];

  protected $casts = [
    'data' => 'object'
  ];

  public function settingable()
  {
    return $this->morphTo();
  }

}
