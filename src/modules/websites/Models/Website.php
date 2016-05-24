<?php

namespace P3in\Models;

use Auth;
use Carbon\Carbon;
use P3in\Traits\HasGallery;
use P3in\Traits\HasPermissions;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\SettingsTrait;
use P3in\Traits\OptionableTrait;
use P3in\Traits\AlertableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Sftp\SftpAdapter;
use Less_Parser;
use Log;
use P3in\Module;
use P3in\Models\Photo;
use P3in\Models\Page;
use Imagick;
use ImagickPixel;

class Website extends Model
{

    use AlertableTrait, OptionableTrait, SettingsTrait, NavigatableTrait, HasGallery, HasPermissions;

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
    protected $with = ['options'];

    /**
     * Model's rules
     */
    public static $rules = [
        'site_name' => 'required|max:255', //|unique:websites // we need to do a unique if not self appproach.
        'site_url' => 'required',
        'config.host' => 'required:ip',
        'config.username' => 'required',
        'config.privateKey' => 'required_without:config.password',
        'config.password' => 'required_without:config.privateKey',
        'config.root' => 'required',
        'config' => 'site_connection', // in WebsitesServiceProvider.php:
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

    public function logo()
    {
        return $this->morphOne(Photo::class, 'photoable');
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
     *  addItem ?
     *  TODO Remove
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
     *  getCurrent
     */
    public static function getCurrent()
    {
        return static::$current;
    }

    /**
     *  current website
     */
    public static function current(Request $request = null)
    {
        return static::$current ?: Website::admin();
    }

    /**
      * return admin
      *
      */
    public function scopeAdmin($query)
    {
        return $query->where('site_name', '=', env('ADMIN_WEBSITE_NAME', 'CMS Admin CP'))->firstOrFail();
    }

    /**
      * return all but admin
      *
      */
    public function scopeManaged($query)
    {
        return $query->where('site_name', '!=', env('ADMIN_WEBSITE_NAME', 'CMS Admin CP'));
    }

    public static function isManaged()
    {
        return Website::current()->id !== Website::admin()->id;
    }

    /**
      *
      *
      */
    public function scopeManagedById($query, $id)
    {
        return $query->managed()->findOrFail($id);
    }

    public function scopeIsLive($query)
    {
        return $query->whereHas('settings', function($query){
            $query->where("data->>'live'", 'true');
        });
    }

    public function getIsLiveAttribute()
    {
        return $this->settings('live') ? 'Yes' : 'No';
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


    public function populateField($field_name)
    {
        switch ($field_name) {
            case 'website_header_list':
                return Section::headers()->orderBy('name')->lists('name', 'id');
                break;
            case 'website_footer_list':
                return Section::footers()->orderBy('name')->lists('name', 'id');
                break;
            default:
                return [];
                break;
        }
    }


    /**
     *  @TODO deployment shouldn't really be a Website responsibility
     */
    public function deploy()
    {

        if (!self::testConnection((array) $this->config)) {

            throw new \Exception('Unable to connect.');

        }

        $ver = Carbon::now()->timestamp;

        $css_path = '/'.$ver.'-style.css';

        $css = $this->buildCss();

        try {

            $disk = $this->getDiskInstance();

            if (!$disk->put($css_path, $css) ) {

                Log::error('Unable to write file on the remote server: '.$this->config->host);

                return false;

            }

            $this->settings('css_file', $css_path);

            return true;

        } catch (\RuntimeException $e) {

            \Log::error($e->getMessage());

            return false;

        }

    }

    /**
      * Get disk instance
      *
      * @param boolean $first_time uses parent as root
      */
    public function getDiskInstance($first_time = false)
    {

        $connection_info = array_replace(Config::get('filesystems.disks.sftp'), (array) $this->config);

        if ($first_time) {

          $connection_info['root'] = dirname($connection_info['root']);

        }

        Config::set('filesystems.disks.sftp', $connection_info);

        $disk = \Storage::disk('sftp');

        return $disk;

    }

    /**
    *  Test connection to website
    *
    *
    */
    public static function testConnection(array $overrides = [], $first_time = false)
    {

        $instance = new static;

        $instance->config = $overrides;

        $disk = $instance->getDiskInstance($first_time);

        try {

          $disk->getAdapter()->getConnection();

        } catch (\LogicException $e) {
            // dd($e->getMessage());
          return false;

        }

        $website_folder = basename($instance->config->root);

        if ($first_time AND !$disk->has($website_folder)) {

          return $disk->createDir($website_folder);

        }

        return true;

    }

    /**
      * buildCSS
      *
      * builds css files out of the settings
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

    /*
    * Store an image as the website logo
    *
    */
    public function addLogo(UploadedFile $file)
    {

        // TODO vvvv BULLCRAP, move it to a separate method
        $connection_info = array_replace(Config::get('filesystems.disks.sftp'), (array) $this->config);

        Config::set('filesystems.disks.'.config('app.default_storage'), $connection_info);

        $photo = Photo::store($file, Auth::user(), [
            'storage' => $this->site_url,
            'file_path' => 'images/',
            'name' => 'logo',
        ], $this->getDiskInstance());

        if (!config('app.skip_alt_logo')) {
            $photo_original_path = $connection_info['root'].$photo->attributes['path'];

            // Now lets create the alternate png version.
            // get file size.
            $sizeCheck = new Imagick($photo_original_path);
            $size = $sizeCheck->getImageGeometry();

            // lets create the png version
            $image = new Imagick();
            $image->setResolution(4096, 4096);
            $image->setBackgroundColor(new ImagickPixel('transparent'));
            $image->readImageBlob(file_get_contents($photo_original_path));
            $image->setImageFormat("png32");
            $image->writeImage($connection_info['root'].str_replace('.svg', '.png', $photo->attributes['path']));
        }


        $this->logo()->delete();

        return $this->logo()->save($photo);
    }

    /**
     * Check if current website has a logo
     */
    public function hasLogo()
    {
        return $this->logo()->exists();
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
