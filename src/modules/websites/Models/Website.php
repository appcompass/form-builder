<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;
use P3in\Traits\SettingsTrait;

class Website extends Model
{

  use SettingsTrait;

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
	protected $fillable = [
		'site_name',
		'site_url',
		'from_email',
		'from_name',
		'managed',
		'ssh_host',
		'ssh_username',
		'ssh_password',
		'ssh_key',
		'ssh_keyphrase',
		'ssh_root',
		'config',
		'published_at',
	];

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
