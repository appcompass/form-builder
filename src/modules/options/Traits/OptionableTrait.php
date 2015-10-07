<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
	protected function setOption($option_label, $option_id)
	{

	$option = OptionStorage::firstOrNew([
		'model' => get_class($this),
		'item_id' => $this->{$this->primaryKey}
	]);

	$option->option_label = $option_label;
	$option->option_id = $option_id;

	return $option->save();
	}

	/**
	*   Retrieve selected options for the model
	*
	*
	*/
	protected function getOption($label)
	{

	try {
		$option_set = Option::where('label', '=', $label)->firstOrFail();

		$content = json_decode($option_set->content, true);

	} catch (ModelNotFoundException $e) {
		return null;
	}

	try {
		$selected_option_id = OptionStorage::where('model', '=', get_class($this))
			->where('item_id', '=', $this->{$this->primaryKey})
			->firstOrFail()
			->option_id;

		return $content[$selected_option_id];

	} catch (ModelNotFoundException $e) {
		return null;
	}

	}
}