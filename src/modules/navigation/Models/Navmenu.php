<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

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

	/**
	*	Get a navmenu by name
	*
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
  *
  *
  */
  public function navigationItems()
  {
    return $this->hasMany('P3in\Models\NavigationItem');
  }

	/**
	*	Link items to Navigation Items
	*
	*
	*/
	public function items()
	{
		return $this->belongsToMany('P3in\Models\NavigationItem');
	}

	/**
	*
	*
	*
	*/
	public function scopeByName($query, $name)
	{
		return $query->where('name', $name)->firstOrFail();
	}
}
