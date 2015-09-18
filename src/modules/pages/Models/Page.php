<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;
use P3in\Traits\NavigatableTrait as Navigatable;
use P3in\Modules\Navigation\LinkClass;

class Page extends Model
{

	use Navigatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'title',
		'description',
		'slug',
		'order',
		'parent',
    'website_id',
		'req_permission',
		'published_at'
	];

	/**
	*	Fields that needs to be treated as a date
	*
	*/
	protected $dates = ['published_at'];

	/**
	*	Properties we want to link the class to
	*
	*	@var array
	*/
	protected $navigation_props = ['id'];

	/**
	*	Get the website the page belongs to
	*
	*
	*/
	// public function website()
	// {
	// 	return $this->belongsTo('Website');
	// }

	/**
	*  Build a LinkClass out of this class
	*
	*
	*
	*/
	protected function makeLink()
	{

		return new LinkClass([
			"label" => $this->title,
			"link_text" => $this->description,
			"model" => get_class($this),
			"url" => $this->slug,
			"new_tab" => false,
			"req_permission" => $this->req_permission,
		]);
	}

	/**
	*
	*
	*
	*/
	// public function template()
	// {
		// return $this->hasOne('template');
	// }
}
