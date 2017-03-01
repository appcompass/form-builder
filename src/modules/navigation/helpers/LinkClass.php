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

	protected $json_attributes = ['props'];

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

			// if (in_array($attribute, $this->json_attributes)) {

			// 	$value = json_encode($value);

			// }

			$this->attributes[$attribute] = $value;

		}

		return $this;
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

	/**
	 *
	 *
	 */
	public function toArray()
	{
	  return $this->attributes;
	}
}