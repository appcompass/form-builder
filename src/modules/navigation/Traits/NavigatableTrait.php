<?php

namespace P3in\Traits;

use Exception;
use Modular;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use P3in\Models\Navigation as Nav;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Modules\Navigation\LinkClass;
use Validator;

trait NavigatableTrait

{

  /**
   *  Return an array of attributes to be stored as NavigationItem for the model
   *
   */
  abstract protected function makeLink($attributes = []);

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
   *
   *
   */
  public function navItem()
  {

    if (str_is('*Module', get_class($this))) {

      $this->id = Modular::get($this->module_name)->id;

      $rel = new MorphOne(
        (new NavigationItem)->newQuery(),
        $this,
        'navigation_items.navigatable_type',
        'navigation_items.navigatable_id',
        'id'
      );

    }

    $rel = $this->morphOne(NavigationItem::class, 'navigatable');

    if ($rel->get()->count() == 0) {

      $rel->save($this->makeNavigationItem());

    }

    return $rel;

  }

	/**
	*	Try getting model's navigationItem or generate one
	*
	*  @param
	*/
	public function getNavigationItem($attributes = null)
  {

    $navItem = $this->navItem()->first();

    if (is_null($navItem)) {

      $navItem = $this->navItem()->save($this->makeNavigationItem());

    }

    return $navItem;

	}

	/**
	*  Get a Navigation Item
	*
	*  @return P3in\Models\NavigationItem
	*/
	private function makeNavigationItem($attributes = [])
	{

    if (!is_null($attributes) && is_array($attributes) ) {

      // set overrides

    }

		return new NavigationItem((new LinkClass($this->makeLink()))->toArray());

	}

}