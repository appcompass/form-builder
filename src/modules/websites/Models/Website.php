<?php

namespace P3in\Models;

use Auth;
use P3in\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
	 */
	public function pages()
	{
		return $this->hasMany(Page::class);
	}

	/**
	 *
	 *
	 */
	public function navmenus()
	{
		return $this->hasMany(Navmenu::class);
	}

	/**
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
	public function addItem(Page $page)
	{
		$this->pages()->save($page);
	}

	/**
	 *
	 *
	 */
	public function scopeAdmin($query)
	{
	  return $query->where('site_name', '=', env('ADMIN_WEBSITE_NAME', 'CMS Admin CP'))->firstOrFail();
	}

	/**
	 *
	 *	@param bool $pages retunrns a link to website's pages index
	 */
	public function makeLink($overrides = [])
	{
	    return array_replace([
	        "label" => $this->site_name,
	        "url" => 'cp/websites'.$this->id.'/pages',
	        "props" => [
	        	"icon" => 'globe',
	        	"link" => [
	        		'data-click' => 'cp/websites/'.$this->id,
	        		'data-target' => '#main-content'
	        	]
	        ]
	    ], $overrides);
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

			if ($page->checkPermissions(Auth::user())) {

                return $page;

            }

		} catch (ModelNotFoundException $e ) {

			return false;

		}

		return false;
	}
}
