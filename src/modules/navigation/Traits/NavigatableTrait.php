<?php

namespace P3in\Traits;

use P3in\Models\Navigation as Nav;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Modules\Navigation\LinkClass;
use P3in\Traits\JsonPropScopesTrait as JsonProp;
use Validator;
use Exception;

trait NavigatableTrait

{

  use JsonProp;

  /**
  *  linkToNavmenu
  *
  *  @param Navmenu $navmenu instance of the navmenu the item needs to be linked to
  *  @param @mixed attributes  single or array of overrides to pass down
  */
  public function linkToNavmenu(Navmenu $navmenu, $attributes = null)
  {

    try {
      $navmenu
        ->items()
        ->attach($this->navigationItem($attributes));

      return true;

    } catch (Exception $e) {

      throw new Exception($e->getMessage());

    }
  }


	/**
	*	Try getting model's navigationItem or generate one
	*
	*  @param attrbiutes single/array list of overrides to be used instead of class' properties
	*/
	public function navigationItem($attributes = null)
  {

		$navItem = NavigationItem::byModel(get_class($this))
			->withProps(getPgWhereProps($this->navigation_props, $this))
			->first();

		if (is_null($navItem)) {
			return $this->setNavigationItem($attributes);
		} else {
      // update database item with overrides
    }

		return $navItem->first();

	}

	/**
	*
	*
	*
	*
	*/
	public function getNavigation()
	{
		return "Navigation";
	}

	/**
	*	Set Navigation
	*
	*	set LinkClass defaults for adding a NavigationItem
	*/
	private function setNavigationItem($attributes = [])
	{

    if (!is_null($attributes) && is_array($attributes) ) {

      // set overrides

    }

		$link = $this->makeLink();

		$link->attributes['props'] = json_encode(getProps($this->navigation_props, $this));

		$validate = Validator::make($link->attributes, NavigationItem::$rules);

		if ($validate->passes()) {

			return NavigationItem::create($link->attributes);

		} else {

      throw new Exception($validate->messages()->all());

		}

	}

	/**
	*	Make Link provides content for building a LinkClass
	*	to be stored as a NavigationItem
	*
	*
	*/
	abstract protected function makeLink($attributes = []);
}