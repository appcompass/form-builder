<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Section;

class Template extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'templates';

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
	public function render()
	{

		$out = '';

	  foreach ($this->sections as $section) {

	  	$out .= $section->render();

	  }

	  return $out;
	}

	/**
	*
	*
	*
	*/
	public function sections()
	{
		$rel = $this->belongsToMany(Section::class);

		return $rel;
	}
}
