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
  abstract protected function makeLink($overrides = []);

  /**
   *
   *
   */
  public function navItem($overrides = [], $pretend = false)
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

    if (!$rel->get()->count() || count($overrides)) {

        if ($pretend) {

          return $this->getNavigationItem($overrides);

        } else {

          $rel->save($this->makeNavigationItem($overrides));

        }

    }

    return $rel;

  }

  /**
   *  Get the raw Navigation Item instance
   *
   */
  public function getNavigationItem(array $overrides = [])
  {

    return $this->makeNavigationItem($overrides);

  }

	/**
	*  Get a Navigation Item
	*
	*  @return P3in\Models\NavigationItem
	*/
	private function makeNavigationItem($overrides = [])
	{

    if (count($overrides)) {

      $link = (new LinkClass($this->makeLink($overrides)))->toArray();

      // $link = array_replace($link, $attributes);

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