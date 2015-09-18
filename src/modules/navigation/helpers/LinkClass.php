<?php

namespace P3in\Modules\Navigation;

use P3in\Models\NavigationItem;

/**
*		Navigation Helpers
*
*
*
*/
class LinkClass
{

	public $attributes = [];

	/**
	*
	*
	*
	*
	*/
	public function __construct($attributes = [])
	{

		return $this->boot($attributes);

	}

	/**
	*
	*
	*
	*
	*/
	private function boot($attributes = [])
	{

		foreach($attributes as $attribute => $value) {

			$this->attributes[$attribute] = $value;

		}

		return $this->attributes;
	}

	/**
	*
	*
	*
	*/
	public function __get($property)
	{

		if (in_array($property, $this->attributes)) {

			return $this->attributes[$property];

		}

	}
}