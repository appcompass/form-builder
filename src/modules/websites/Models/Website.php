<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;

class Website extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'websites';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	*	Fields that needs to be treated as a date
	*
	*/
	protected $dates = ['published_at'];

	/**
	*	Get all the pages linked to this website
	*
	*
	*/
	public function pages()
	{
		return $this->hasMany('P3in\Models\Page');
	}

  /**
  *
  *
  *
  *
  */
  public function navmenus()
  {
    return $this->hasMany("P3in\Models\Navmenu");
  }

  /**
  *
  *
  *
  *
  */
  public function scopeByName($query, $name)
  {
    return $query->where('site_name', '=', $name);
  }

	/**
	*
	*
	*
	*
	*/
	public function addPage()
	{
		// this->
	}

	/**
	*
	*	Website::first()->render()
	*
	*
	*/
	public function render()
	{
		$pages = $this->pages;

		$user  =Auth::user()->permissions;

		//
		//
		//
	}
}
