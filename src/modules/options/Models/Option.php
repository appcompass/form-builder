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
    'content',
    'multiple'
  ];

  protected $casts = [
    'content' => 'array'
  ];

  /**
   *  Hidden Fields
   *
   */
  protected $hidden = [];

  /**
   *   Get option set by label - all the content
   *
   */
  public static function byLabel($label)
  {
    return static::where('label', '=', $label)
      ->firstOrFail();
  }

  /**
  * add an option to an options set or create it
  *
  * @param (string) label   Option's Label
  * @param (mixed)  content   Content that will be stored
  * @param (bool) multiple Does the option allow multiple selections?
  */
  public static function set($label, array $new_content, $multiple = false)
  {

    try {

      $options_set = Option::whereLabel($label)
        ->firstOrFail();

      $new_content = static::setIds($new_content, static::getNextId($options_set->content));

      $options_set->content = array_merge($options_set->content, $new_content);

      if ($options_set->save()) {

        return $options_set->content;

      }

      return false;

    } catch (ModelNotFoundException $e) {

      return Option::create([
        'label' => $label,
        'content' => static::setIds($new_content, 1)
      ])->content;

    }

  }

  /**
   *  remove an option from an options set
   *
   */
  public static function remove($label, $id)
  {
    try {

      $options_set = Option::whereLabel($label)
        ->firstOrFail();

      $content = $options_set->content;

      foreach($content as $key => $values) {

        if ($values['_id'] === $id) {

          unset($content[$key]);

        }

      }

      $options_set->content = $content;

      return $options_set->save();

    } catch (ModelNotFoundException $e) {

      return false;

    }

  }

  /**
   * Provide next id entry
   *
   */
  private static function getNextId($items)
  {
    return max(array_pluck($items, '_id')) + 1;
  }

  /**
   *  Recursively add _id to an array's first level
   *
   *  @param array $items   Items to get the _id
   *  @param int $index   Initial offset
   */
  private static function setIds(array $items, $index = 1)
  {

    $result = [];

    foreach($items as $key => $value) {

      // if $key is numeric the input is an array of arrays, which
      // means the programmer wants to set multiple options at once
      if (is_numeric($key)) {
        array_push($result, ['_id' => $index] + $value );
      } else {
        array_push($result, ['_id' => $index] + $items );
      }

      $index++;

    }

    return $result;

  }

}