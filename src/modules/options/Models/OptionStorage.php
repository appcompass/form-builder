<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class OptionStorage extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'options_storage';

  /**
  * Establish timestamps presence
  *
  *
  *
  */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'model',
    'item_id',
    'option_label',
    'option_id'
  ];

  /**
  *
  *
  *
  *
  */
  protected $hidden = [];

}