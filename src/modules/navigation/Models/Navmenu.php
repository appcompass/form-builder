<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Traits\NavigatableTrait;
use Exception;
use DB;

class Navmenu extends Model
{

	use NavigatableTrait;

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
		'label',
		'req_permission',
		'parent_id',
		'website_id'
	];

	protected $with = ['children.items', 'items'];

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
	 *	Relation to self (parent)
	 *
	 */
	public function parent()
	{
	  return $this->belongsTo(Navmenu::class, 'parent_id');
	}

	/**
	 * Set a parent of this navmenu
	 *
	 */
	public function setParent(Navmenu $navmenu)
	{
	  return $this->parent()->associate($navmenu);
	}

	/**
	 *	Relation to self (children)
	 *
	 */
	public function children()
	{
		return $this->hasMany(Navmenu::class, 'parent_id');
	}

	/**
	 *	Add a child nav
	 *
	 */
	public function addChildren(Navmenu $navmenu)
	{
	  $this->children()->save($navmenu);
	  return $this->addItem($navmenu);
	}

	/**
	 *	Unlink a child nav
	 *
	 */
	public function removeChildren(Navmenu $navmenu)
	{

	  $navmenu->parent_id = null;

	  return $navmenu->save();

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
	 *	TODO find a way to take user out of here?
	 */
	public function items()
	{

		$user_permissions = [];

		if (\Auth::check()) {

			$user_permissions = \P3in\Models\User::find(173)->first()->allPermissions();

		}

		return $this->belongsToMany('P3in\Models\NavigationItem')
			->whereIn('req_perms', $user_permissions)
			->withPivot('order')
			->orderBy('order');

	}

	/**
	 *	Try to link the instance passed to this navmenu
	 *
	 *	@param mixed $navItem either an instance of NavigationItem or an object which navItem's method returns an instance of NavigationItem
	 */
	public function addItem($navItem)
	{

		if (method_exists($navItem, 'navItem')) {

			return $this->addItem($navItem->navItem);

		}

		if (!$navItem instanceof NavigationItem) {

			throw new Exception("Can't add item to {$this->name}.");

		}

		if (! $this->items->contains($navItem)) {

			$order = intVal( DB::table('navigation_item_navmenu')
				->where('navmenu_id', '=', $this->id)
				->max('order') ) + 1;

		  $this->items()->attach($navItem, ['order' => $order] );

		}

		return true;

	}

	/**
	 *	Get or create navigation menu by name
	 *
	 */
	public function scopeByName($query, $name, $label = null)
	{

		$navmenu = Navmenu::where('name', '=', $name)->first();

		if (is_null($navmenu)) {

			if (is_null($label)) {

				$label = ucfirst(str_replace('-', ' ', $name));

			}

			$navmenu = $this->make([
				'name' => $name,
				'label' => $label,
				'description' => null
			]);

			$navmenu->load('items', 'children.items');

		}

		return $navmenu;

	}

	/**
	 * Navmenu making routine
	 *
	 * TODO expand on overrides
	 */
	public function make(array $attributes = [])
	{

	  return Navmenu::create($attributes);

	}

	/**
	 *	NavigatableTrait implementation
	 *
	 */
	public function makeLink()
	{
	    return [
	        "label" => $this->label,
	        "url" => '',
	        "has_content" => true,
	        "req_perms" => null,
	        "props" => [
	        	"icon" => 'list',
	        	"link" => [
	        		'data-click' => ''
	        	]
	        ]
	    ];
	}
}
