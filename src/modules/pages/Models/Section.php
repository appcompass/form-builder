<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Template;
use P3in\Models\Website;

class Section extends Model
{


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
	 *
	 *
	 *
	 */
	public function render($data)
	{

		return $this->display_view;

		// return view($this->display_view)->with('data', $data)->render();
		// return view($this->display_view)->render();
		// return view($this->display_view)->render();

	}

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
