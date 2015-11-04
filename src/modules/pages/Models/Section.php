<?php

namespace P3in\Models;

use BostonPads\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Template;
use P3in\Models\Website;
use P3in\Traits\NavigatableTrait;

class Section extends Model
{

	use NavigatableTrait;

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
	 */
	public function photos()
	{
	  return $this->morphMany(Photo::class, 'photoable');
	}

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
	 */
	public function makeLink($attributes = [])
	{
		return [
		  "label" => $this->name,
		  "url" => 'section/'.$this->id.'/edit',
		  "req_perms" => null,
		  "props" => [
		      'icon' => 'list',
		      "link" => [
		          'data-click' => '/cp/sections/'.$this->id,
		          'data-target' => '#main-content'
		      ],
		  ]
		];
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
