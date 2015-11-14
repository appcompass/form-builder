<?php

namespace P3in\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use P3in\Models\Page;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\SettingsTrait;

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


    public function scopeCurrent($query, Request $request = null)
    {
        // unfortunately the first time we run this we need to pass the current Request. which is why we need to
        // run this on app before filters for all requests.
        if (!Config::get('current_site_record')) {
            Config::set('current_site_record',  $query->where('site_name','=', $request->header('site-name'))->firstOrFail());
        }

        return Config::get('current_site_record');
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
	        "url" => '/websites'.$this->id.'/pages',
	        "props" => [
	        	"icon" => 'globe',
	        	"link" => [
	        		'data-click' => '/websites/'.$this->id,
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
