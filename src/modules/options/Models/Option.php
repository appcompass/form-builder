<?php

namespace P3in\Models;

use DB;
use Cache;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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

  /**
   *
   */
  protected $casts = [
    'content' => 'object'
  ];

  /**
   *  Hidden Fields
   *
   */
  protected $hidden = [];

  /**
  * Add an option to an options set or create it
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

      // if (!is_null($options_set->content)) {

        $new_content = static::setIds($new_content, static::getNextId($options_set->content));

      // } else {

        // $options_set->content = [];

      // }

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

      $options_set = self::byLabel($label);

      $collection = collect($options_set->content);

      foreach($collection as $key => $values) {

        if ($values->_id === $id) {

          $collection->forget($key);

        }

      }

      $options_set->content = $collection->toArray();

      return $options_set->save();

    } catch (ModelNotFoundException $e) {

      return false;

    }

  }

  /**
   *  Get item value
   *
   */
  public static function getItemValue($label, $id, $item = '*')
  {

    $result = static::byLabelAndId($label, $id)->first();

    if (count($result)) {

      if ($item == '*') {
        return $result;
      } else {
        return $result->$item;
      }

    }

    return $result;

  }

  /**
   *
   */
  public static function items($label)
  {

    $result = static::byLabel($label);

    if (!count($result)) {

      return null;

    }

    return collect($result->content);

  }

  /**
   *   Get option set by label - all the content
   *
   */
  public static function byLabel($label)
  {

    return Cache::remember($label, 1, function() use($label) {

      return Option::where('label', $label)
        ->limit(1)
        ->get(['id', 'content', 'multi'])
        ->first();
    });

  }

  /**
   *  Get an option value
   *
   */
  public static function byLabelAndId($label, $id)
  {

    if (!is_array($id)) {

      $id = explode(',', $id);

    }

    $options = static::items($label);

    if (is_null($options)) {

      throw new Exception("Option <$label> appears to be empty.");

    }

    $result = new Collection();

    foreach ($id as $single_id) {

      $option = $options
        ->where('_id', intval($single_id))
        ->first();

      if (!count($option)) {
        throw new \Exception("One or more stored option(s) not found in <$label>.");
      }

      $result->push($option);

    }

    if (static::byLabel($label)->multi) {

      return $result;

    }

    return $result->first();

  }

  /**
   * Provide next id entry
   *
   */
  private static function getNextId($items)
  {

    if (is_array($items) && count($items) > 1) {

      return max(array_pluck($items, '_id')) + 1;

    }

    return 1;

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