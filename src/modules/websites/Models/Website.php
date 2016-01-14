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
use HasGallery;

class Website extends Model
{

    use SettingsTrait, NavigatableTrait, HasGallery;

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
     *
     */
    public static $current = null;

    /**
     *
     */
    protected $with = [];

    /**
     * Model's rules
     */
    public static $rules = [
        'site_name' => 'required|max:255', //|unique:websites // we need to do a unique if not self appproach.
        'site_url' => 'required',
        'config.host' => 'required:ip',
        'config.username' => 'required',
        'config.password' => 'required',
        'config.root' => 'required',
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
     *  Link a page
     *
     */
    public function addPage(Page $page)
    {
    $this->pages()->save($page);
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
    public static function setCurrent(Website $website)
    {

        return static::$current = $website;

    }

    /**
     *
     */
    public static function getCurrent()
    {

        return static::$current;

    }

    /**
     *
     */
    public static function current(Request $request = null)
    {

        return static::$current;

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
     *
     */
    public function scopeManaged($query)
    {
        return $query->where('site_name', '!=', env('ADMIN_WEBSITE_NAME', 'CMS Admin CP'));
    }

    public function scopeManagedById($query, $id)
    {
        return $query->managed()->findOrFail($id);
    }
    /**
     *
     *  @param bool $pages retunrns a link to website's pages index
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

    /**
     *
     */
    public function deploy()
    {

        if (!$this->testConnection((array) $this->config)) {

            throw new \Exception('Unable to connect.');

        }

        $ver = Carbon::now()->timestamp;

        $saved_css_file = '/'.$ver.'-style.css';

        $css = $this->buildCss();

        try {

            if (!$this->getDiskInstance()->put($saved_css_file, $css) ) {

            \Log::error('Unable to write file on the remote server: '.$this->config->host);

            return false;

            }

            $this->settings('css_file', $saved_css_file);

            return true;

        } catch (\RuntimeException $e) {

            \Log::error($e->getMessage());

            return false;

        }

    }

    /**
     *
     */
    public function getDiskInstance()
    {

        $connection_info = array_replace(Config::get('filesystems.disks.sftp'), (array) $this->config);

        Config::set('filesystems.disks.sftp', $connection_info);

        $disk = \Storage::disk('sftp');

        return $disk;

    }

    /**
    *  Test connection to website
    */
    public static function testConnection(array $overrides = [])
    {

        $instance = new static;

        $instance->config = $overrides;

        $connection_details = array_replace((array) config('filesystems.disks.sftp'), $overrides);

        $disk = $instance->getDiskInstance()
            ->getDriver()
            ->getAdapter();

        try {

            $disk->connect();

            $result = $disk->isConnected();

            $disk->disconnect();

            return $result;

        } catch (\RuntimeException $e) {

            \Log::error($e->getMessage());
            return false;

        } catch (\ErrorException $e) {

            \Log::error($e->getMessage());
            return false;

        } catch (\LogicException $e) {

            \Log::error($e->getMessage());
            return false;

        }

    }

    /**
     *
     */
    public function buildCss()
    {

        $parser = new Less_Parser(config('less'));

        $parser->parseFile(config('less.less_path'));

        $parser->ModifyVars([
            'color-theme-primary'=> $this->settings('color_primary'),
            'color-theme-secondary' => $this->settings('color_secondary'),
        ]);

        return $parser->getCss();

    }

    /**
     *
     */
    public function getMachineName()
    {
        return strtolower(str_replace(' ', '_', $this->site_name));
    }

    /**
     * as per hasGallery Trait
     */
    public function getGalleryName()
    {
        return $this->getMachineName();
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
