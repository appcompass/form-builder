<?php

namespace P3in\Traits;

// use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Option;
use P3in\Models\OptionStorage;

trait OptionableTrait
{
  /**
  *
  *
  *
  *
  */
  public function setOption($option_label, $option_id)
  {

    $option = OptionStorage::firstOrNew([
      'model' => get_class($this),
      'item_id' => $this->id
    ]);

    $option->option_label = $option_label;
    $option->option_id = $option_id;

    return $option->save();
  }

  /**
  *
  *
  *
  *
  */
  public function getOption($label)
  {

    $option_set = Option::where('label', '=', $label)->firstOrFail();

    $content = json_decode($option_set->content, true);

    $selected_option_id = OptionStorage::where('model', '=', get_class($this))
      ->where('item_id', '=', $this->id)
      ->firstOrFail()
      ->option_id;

    return $content[$selected_option_id];
  }
}