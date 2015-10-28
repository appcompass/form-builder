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
		'link_text',
		'model',
		'url',
		'new_tab',
		'req_permission',
		'params',
		'props'
	];

	/**
	 *	Validation Rules
	 *
	 */
	public static $rules = [
		'label' => 'required',
		'link_text' => 'required',
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
	 * Navigatable polymorphic
	 *
	 */
	public function navigatable()
	{
	  return $this->morphTo();
	}

}