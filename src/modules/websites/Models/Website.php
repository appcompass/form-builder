<?php

namespace P3in\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Less_Parser;
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

    public static $validator_rules = [
        'site_name' => 'required|unique:websites|max:255',
        'site_url' => 'required',
        'config' => 'site_connection',
    ];
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
   */
    public static function current(Request $request = null)
    {

        // unfortunately the first time we run this we need to pass the current Request. which is why we need to
        // run this on app before filters for all requests.
        if (!Config::get('current_site_record') && $request) {

            $site_name = $request->header('site-name');

            if (!empty($site_name)) {

                $website = Website::where('site_name', '=', $site_name)->firstOrFail();

                Config::set('current_site_record', $website);

            }

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
	        "url" => '/websites/'.$this->id.'/pages',
	        "props" => [
	        	"icon" => 'globe',
	        	"link" => [
	        		'href' => '/websites/'.$this->id,
	        		'data-target' => '#main-content-out'
	        	]
	        ]
	    ], $overrides);
	}

    private function connectionConfig($config)
    {
        // set the remote site's ssh connection config.
        config(['remote.connections.production' => [
            'host'      => $config->ssh_host,
            'username'  => $config->ssh_username,
            'key'       => $config->ssh_key,
            'keyphrase' => $config->ssh_keyphrase,
        ]]);

    }

    public function initRemote()
    {
        $this->connectionConfig($this->config);
        $data = $this->config->server;
        $data->document_root = $this->config->ssh_root;
        $data->site_name = $this->site_name;

        $nginx_config = (string) view('websites::server.nginx_main', ['data' => $data]);

        SSH::putString($this->config->ssh_root.'/../nginx.conf', $nginx_config);

        SSH::run("sudo service nginx restart &", function($line) {
            var_dump($line);
        });
    }

    public function deploy()
    {
        $this->connectionConfig($this->config);

        // Getting settings like this seems wrong? could have sworn there was a shorter way to handle this.
        $settings = $this->settings()->first()->data;

        $ver = Carbon::now()->timestamp;

        $output = [];

        // Now lets compile and output the css contents to a string.
        $saved_css_file = '/'.$ver.'-style.css';

        $parser = new Less_Parser(config('less'));
        $parser->parseFile(config('less.less_path'));
        $parser->ModifyVars([
            'color-theme-primary'=> $settings->color_primary,
            'color-theme-secondary' => $settings->color_secondary,
        ]);

        // the string containing this sites' CSS file.
        $css = $parser->getCss();

        // Now lets put that file on the remote site.
        SSH::putString($this->config->ssh_root.$saved_css_file, $css);

        // Once this has run successfully, we save the file names to the config of the website.
        $settings->css_file = $saved_css_file;

        $this->settings((array) $settings); // doesn't like objects :/

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
