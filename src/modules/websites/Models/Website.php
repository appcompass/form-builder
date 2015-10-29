<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Page;
use P3in\Traits\SettingsTrait;
use P3in\Traits\NavigatableTrait;

class Website extends Model
{

	use SettingsTrait, NavigatableTrait;

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
		'config',
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'config' => 'object',
	];

	/**
	* Fields that needs to be treated as a date
	*
	*/
	protected $dates = ['published_at'];

	/**
	* Get all the pages linked to this website
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
	 */
	public function scopeByName($query, $name)
	{
		return $query->where('site_name', '=', $name);
	}

	/**
	 *
	 *
	 */
	public function addPage()
	{
		// this->
	}

	/**
	 *
	 */
	public function makeLink()
	{
	    return [
	        "label" => $this->site_name,
	        "url" => '',
	        "has_content" => false,
	        "req_perms" => null,
	        "props" => [
	        	"icon" => 'globe',
	        	"link" => [
	        		'data-click' => 'websites/'.$this->id,
	        		'data-target' => ''
	        	]
	        ]
	    ];
	}

	/**
	*
	* Website::first()->render()
	*
	*
	*/
	public function renderPage($page_path)
	{

		try {

			$page = $this->pages()
				->where('slug', $page_path)
				->firstOrFail();

			if ($page->checkPermissions(\Auth::user())) {

                return $page;

            }

		} catch (ModelNotFoundException $e ) {

			return false;

		}

		return false;
	}
}
