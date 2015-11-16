<?php

namespace P3in\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use P3in\Models\Page;
use P3in\Module;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\SettingsTrait;
use SSH;

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
        if (!config('current_site_record')) {
            config(['current_site_record' => $query->where('site_name','=', $request->header('site-name'))->firstOrFail()]);
        }

        return config('current_site_record');
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
	        "url" => '/websites/'.$this->id.'/pages',
	        "props" => [
	        	"icon" => 'globe',
	        	"link" => [
	        		'data-click' => '/websites/'.$this->id,
	        		'data-target' => '#main-content-out'
	        	]
	        ]
	    ], $overrides);
	}

    public function initRemote()
    {

        config(['remote.connections.production' => [
            'host'      => $this->config->ssh_host,
            'username'  => $this->config->ssh_username,
            'key'       => $this->config->ssh_key,
            'keyphrase' => $this->config->ssh_keyphrase,
        ]]);

        $ver = Carbon::now()->timestamp;

        $output = [];

        // we can only put 1 file at a time so this is it.
        // Also for now we are putting the actual resulting file.
        // normally we'll be posting a precompiled file and then
        // run the remote command to compile the css passing the
        // variables for settings when the settings are saved.

        // this gulp packages.json and gulpfile.js are ONLY used for compiling the style.css file.
        $module_root = Module::byName('websites')->getPath();


        // $gulp_conf = $module_root.'/deployer/package.json';

        // SSH::put($gulp_conf, $this->config->ssh_root.'/../package.json');

        // config('app.less_file_path')
        // $gulp_file = $module_root.'/deployer/gulpfile.js';


// gulp --gulpfile public/gulpfile.js

        // SSH::put($gulp_file, $this->config->ssh_root.'/../gulpfile.js');


        // Now lets compile and output the css file to the site.
        $local_css_file = public_path('assets/toolkit').'/styles/toolkit.css';
        $saved_css_file = '/'.$ver.'-style.css';

        SSH::put($local_css_file, $this->config->ssh_root.'/..'.$saved_css_file);

        // and the JS file.
        $local_js_file = public_path('assets/toolkit').'/scripts/toolkit.js';
        $saved_js_file = '/'.$ver.'-script.js';

        SSH::put($local_js_file, $this->config->ssh_root.'/..'.$saved_js_file);

        // // Now lets run remote commands to compile the css using variables.
        // // Getting settings like this seems wrong? could have sworn there was a shorter way to handle this.

        // $settings = $this->settings()->first()->data;

        // if (!empty($settings->color_primary) && !empty($settings->color_secondary)) {
        //     $command = "gulp --primary '{$settings->color_primary}' --secondary '{$settings->color_secondary}'";
        //     $output[] = ["running: {$command}"];

        //     SSH::run([

        //         "cd {$this->config->ssh_root}/..",
        //         $command,

        //     ], function($line) use (&$output) {
        //         $output[] = $line.PHP_EOL;
        //     });

        //     var_dump($output);

        //     // Once this has run successfully, we save the file names to the config of the website.
        //     $settings->css_file = $saved_css_file;
        //     $settings->js_file = $saved_js_file;

        //     $this->settings((array) $settings);
        // }
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
