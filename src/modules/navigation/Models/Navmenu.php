<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Navmenu extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'navmenus';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'req_permission',
		'parent_id'
	];

	protected $with = ['children', 'items'];

	/**
	 *	Get a navmenu by name
	 *
	 *
	 */
	public function scopeName($query, $name)
	{
		return $query->where('name', $name);
	}

	/**
	 *
	 *
	 */
	public function parent()
	{
	  return $this->belongsTo(Navmenu::class, 'parent_id');
	}

	/**
	 *
	 *
	 */
	public function children()
	{
		return $this->hasMany(Navmenu::class, 'parent_id');
	}

  /**
   *
   *
   *
   */
  public function item()
  {
    return $this->item();
  }

	/**
	 *	Link items to Navigation Items
	 *
	 */
	public function items()
	{
		return $this->belongsToMany('P3in\Models\NavigationItem')->withPivot('order');
	}

	/**
	 *	Try to link the instance passed to this navmenu
	 *
	 *	@param mixed $navItem either an instance of NavigationItem or an object which navItem method returns an instance of NavigationItem
	 */
	public function addItem($navItem)
	{

		if ($navItem instanceof NavigationItem) {

			$order = intVal( DB::table('navigation_item_navmenu')
				->where('navmenu_id', '=', $this->id)
				->max('order') ) + 1;

		  return $this->items()->attach($navItem, ['order' => $order] );

		} else if(method_exists($navItem, 'navItem')) {

			$navItem = $this->addItem($navItem->navItem);

		}

		return false;

	}

	/**
	 *	Get navigation menu by name
	 *
	 *
	 */
	public function scopeByName($query, $name)
	{
		return $query->where('name', $name)->firstOrFail();
	}
}
