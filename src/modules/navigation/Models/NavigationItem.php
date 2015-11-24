<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Navmenu;

class NavigationItem extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'navigation_items';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'label',
		'url',
		'new_tab',
		'has_content',
		'alt_text',
		'req_perms',
		'props'
	];

	/**
	 *
	 */
	protected $casts = [
		'props' => 'array'
	];

	/**
	 *	Validation Rules
	 *
	 */
	public static $rules = [
		'label' => 'required',
		'model' => 'required',
		'url' => 'required'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 *
	 *
	 */
	public function navmenu()
	{
	  return $this->belongsToMany(Navmenu::class);
	}

	/**
	 * Navigatable polymorphic
	 *
	 */
	public function navigatable()
	{
	  return $this->morphTo();
	}

	/**
	 *
	 */
	public function getNameAttribute()
	{
	  return snake_case($this->label);
	}

}