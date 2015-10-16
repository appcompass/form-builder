<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Option;

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
   * Hidden from toArray and toJson
   */
  protected $hidden = [];


  /**
   *
   */
  public function optionable()
  {
    return $this->morphTo();
  }

  public function option()
  {
    return $this->belongsTo(Option::class, 'option_label', 'label');
  }

}