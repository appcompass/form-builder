<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Option extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'options';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'label',
    'content'
  ];

  /**
  *
  *
  *
  *
  */
  protected $hidden = [];

  /**
  *   fetches an option by label
  *
  *
  *
  */
  public function scopeByLabel($query, $label)
  {

    return $query->where('label', '=', $label)
      ->firstOrFail()
      ->content;

  }

  /**
  * add an option to an options set or create it
  *
  * @param string label
  * @param array $content
  */
  public static function add($label, array $new_content)
  {

    try {

      $options_set = Option::where('label', '=', $label)->firstOrFail();

      $content = json_decode($options_set->content, true);

      $content[max(array_keys($content)) + 1] = $new_content;

      $options_set->content = json_encode($content);

      $options_set->save();

      return $options_set;

    } catch (ModelNotFoundException $e) {

      $content = ["1" => $new_content];

      return Option::create([
        'label' => $label,
        'content' => json_encode($content)
      ]);

    }

  }
}