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
   *
   *
   */
  public function navItem($attributes = [])
  {

    if (str_is('*Module', get_class($this))) {

      $this->id = Modular::get($this->module_name)->id;

      $rel = new MorphOne(
        (new NavigationItem)->newQuery(),
        $this,
        'navigatable_type',
        'navigatable_id',
        'id'
      );

    } else {

      $rel = $this->morphOne(NavigationItem::class, 'navigatable');

    }

    if (!$rel->get()->count() || count($attributes)) {

      $rel->save($this->makeNavigationItem($attributes));

    }

    return $rel;

  }

  /**
   *  Get the raw Navigation Item instance
   *
   */
  public function getNavigationItem(array $attributes = [])
  {

    $navItem = $this->makeNavigationItem($attributes);

  }

	/**
	*  Get a Navigation Item
	*
	*  @return P3in\Models\NavigationItem
	*/
	private function makeNavigationItem($attributes = [])
	{

    if (count($attributes)) {

      $link = (new LinkClass($attributes))->toArray();

    } else {

      $link = (new LinkClass($this->makeLink()))->toArray();

    }

    $props = '';

    /**
     * To provide a reliable matching and avoid duplicate instances we
     * are temporary removing the json field props (if present)
     */

    if (isset($link['props'])) {

      $props = $link['props'];

      unset($link['props']);

    }

		$item = NavigationItem::firstOrNew($link);

    $item->props = $props;

    return $item;

	}

}