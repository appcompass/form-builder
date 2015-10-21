<?php

/**
 * 	Plus 3 Interactive OptionableTrait
 *
 * 	provides an abstraction for transparently handling options
 *
 *	Usage: add a 'use OptionableTrait' clause in your class
 *
 *	Methods:
 *		setOption(string $option_label, mixed $option_id)				Set an option/s for the current model
 *		setOptions(array $options)															Set multiple options at once
 *		getOption(string $label)																Get model's associated options
 *
 *	Relations:
 *		options()																								Reurns a relation
 */

namespace P3in\Traits;

use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use P3in\Models\Option;
use P3in\Models\OptionStorage;

trait OptionableTrait
{

	private $cache = [];

	/**
	 *	Set an option
	 *
	 *	Add:
	 *	<Model>->setOption('option-label', [<ids>]/<id>)
	 *	Remove:
	 *	<Model>->setOption('option-label', null)
	 *
	 *	@param (mixed) $label Option label
	 *	@param (mixed)	$id 	Single/Multi Option ids to store. NULL deletes
	 *	@return (bool)
	 */
	public function setOption($label, $id)
	{

		if (is_array($label) || is_array($id)) {
			return $this->setOptions([$label => $id]);
		}

		if (!is_null($id) && !$this->checkOption($label, $id)) {
			throw new Exception("One or more options _id <$id> don't exist in <$label>");
		}

		$optStored = $this->options()
			->firstOrNew(['option_label' => $label]);

		if (is_null($id)) {

			return $optStored->delete();

		}

		$optStored->option_id = $id;
		$optStored->option_label = $label;

		$this->options()->save($optStored);

		return true;
	}

	/**
	 *  Get option
	 *
	 *
	 */
	public function getOption($label, $item = null)
	{

		$option = $this->singleOption($label);

		if (is_null($option)) {
			return;
		}

		$selected = Option::byLabelAndId($option->option_label, $option->option_id);

		if (!is_null($item) && count($selected) == 1) {

				return $selected->$item;

		}

		return $selected;

	}

	/**
	 *	Options relation
	 *
	 *
	 */
	public function options()
	{
	  return $this->morphMany(OptionStorage::class, 'optionable');
	}

	/**
	 *	Set multiple options at once
	 *
	 */
	private function setOptions(array $options)
	{

		foreach($options as $label => $id) {

			$option = Option::byLabel($label);

			if (is_array($id) ) {

				if (!$option->multi) {

					throw new Exception("This setting doesn't take multiple items.");

				}

				$id = implode(',', $id);

			}

			$this->setOption($label, $id);

		}

		return true;

	}

	/**
	 *	Chek if an option exists
	 *
	 *
	 */
	private function checkOption($label, $id)
	{
		return count(Option::byLabelAndId($label, $id)) === count(explode(',', $id));
	}

	/**
	 *	Single option getter
	 *
	 *
	 */
	private function singleOption($option_label)
	{

		return $this->options
			->where('option_label', $option_label)
			->first();

	}


}