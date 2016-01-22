<?php

namespace P3in\Models;

use BostonPads\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use P3in\ModularBaseModel;
use P3in\Models\Page;
use P3in\Models\Template;
use P3in\Models\Website;
use P3in\Pivots\PageSectionPivot;
use P3in\Traits\NavigatableTrait;

class Section extends ModularBaseModel
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
		'name',
		'fits',
		'display_view',
		'edit_view',
		'config',
		'type'
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
	// public function render()
	// {
	// 	return [
	// 		'view' => '/sections'.$this->display_view,
	// 		'data' => json_decode($this->pivot->content),
	// 	];
	// }

	/**
	 *
	 */
	public function makeLink($overrides = [])
	{
		return array_replace([
		  "label" => $this->name,
		  "url" => 'sections/'.$this->id.'/edit',
		  "req_perms" => null,
		  "props" => [
		      'icon' => 'list',
		      "link" => [
		          'href' => '',
		          'data-target' => '#record-detail'
		      ],
		  ]
		], $overrides);
	}

	/**
	 *
	 */
	public function scopeDraggable($query, $fits = null)
	{

	  $query->where('type', '=', null);

	  if (! is_null($fits)) {

	  	$query->where('fits', '=', $fits);

	  }

	  return $query;

	}

	/**
	 *
	 */
	public function scopeHeaders($query)
	{
	  return $query->where('type', 'header');
	}

	/**
	 *
	 */
	public function scopeFooters($query)
	{
	  return $query->where('type', 'footer');
	}

	/**
	 *
	 */
	public function scopeByType($query, $type)
	{
	  return $query->where('type', '=', $type);
	}

}
