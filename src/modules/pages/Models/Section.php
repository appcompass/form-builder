<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;
use P3in\Traits\NavigatableTrait as Navigatable;
use P3in\Modules\Navigation\LinkClass;

class Section extends Model
{

	use Navigatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sections';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
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
	*
	*
	*
	*/
	public function templates()
	{
		return $this->belongsToMany(Template::class, 'template_sections');
	}
}
