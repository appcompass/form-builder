<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use P3in\Models\Page;
use P3in\Models\Redirect;
use P3in\Traits\HasGallery;
use P3in\Traits\HasJsonConfigFieldTrait;
use P3in\Traits\HasPermissions;
use P3in\Traits\HasStorage;

class Website extends Model
{

    use HasGallery, HasPermissions, HasStorage, SoftDeletes, HasJsonConfigFieldTrait;

    protected $fillable = [
        'name',
        'scheme',
        'host',
        'storage',
        'config',
    ];

    protected $casts = [
        'config' => 'object'
    ];

    protected $hidden = ['config'];

    /**
     *
     */
    public static $current = null;

    /**
     *
     */
    public $appends = ['url'];

    /**
     * Pages
     *
     * @return     hasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Menus
     *
     * @return     hasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Redirects
     *
     * @return     hasMany
     */
    public function redirects()
    {
        return $this->hasMany(Redirect::class);
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function forms()
    {
        return $this->belongsToMany(Form::class);
    }

    public function logo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function apendStoragePath() {
        // @TODO: Needs tie in with website settings with fallback of empty string.
        return '';
    }

    public function afterStorage()
    {
        // need to do anything after we store a website?
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

        return $page;
    }

    /**
     *  addItem ?
     *  TODO Remove
     */
    public function addItem(Page $page)
    {
        $this->pages()->save($page);
    }

    public function getUrlAttribute()
    {
        return $this->attributes['scheme'].'://'.$this->attributes['host'];
    }

    // @TODO refactor big time all following methods.
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
        return $query->whereHas('settings', function ($query) {
            $query->where("data->>'live'", 'true');
        });
    }

    public function getIsLiveAttribute()
    {
        return $this->settings('live') ? 'Yes' : 'No';
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
     */
    public function getMachineName()
    {
        return strtolower(str_replace(' ', '_', $this->site_name));
    }

    public function getPageFromUrl($url)
    {
        try {
            return $this->pages()->byUrl($url)->firstorFail();
        } catch (Exception $e) {
            throw new Exception('There is no page by that URL.');
        }
    }
    // public function populateField($field_name)
    // {
    //     switch ($field_name) {
    //         case 'website_header_list':
    //             return Section::headers()->orderBy('name')->lists('name', 'id');
    //             break;
    //         case 'website_footer_list':
    //             return Section::footers()->orderBy('name')->lists('name', 'id');
    //             break;
    //         default:
    //             return [];
    //             break;
    //     }
    // }


    // /**
    //  *  @TODO deployment shouldn't really be a Website responsibility
    //  */
    // public function deploy()
    // {

    //     if (!self::testConnection((array) $this->config)) {

    //         throw new \Exception('Unable to connect.');

    //     }

    //     $ver = Carbon::now()->timestamp;

    //     $css_path = '/'.$ver.'-style.css';

    //     $css = $this->buildCss();

    //     try {

    //         $disk = $this->getDiskInstance();

    //         if (!$disk->put($css_path, $css) ) {

    //             Log::error('Unable to write file on the remote server: '.$this->config->host);

    //             return false;

    //         }

    //         $this->settings('css_file', $css_path);

    //         return true;

    //     } catch (\RuntimeException $e) {

    //         \Log::error($e->getMessage());

    //         return false;

    //     }

    // }

    // /**
    //   * Get disk instance
    //   *
    //   * @param boolean $first_time uses parent as root
    //   */
    // public function getDiskInstance($first_time = false)
    // {

    //     $connection_info = array_replace(Config::get('filesystems.disks.sftp'), (array) $this->config);

    //     if ($first_time) {

    //       $connection_info['root'] = dirname($connection_info['root']);

    //     }

    //     Config::set('filesystems.disks.sftp', $connection_info);

    //     $disk = \Storage::disk('sftp');

    //     return $disk;

    // }

    // /**
    // *  Test connection to website
    // *
    // *
    // */
    // public static function testConnection(array $overrides = [], $first_time = false)
    // {

    //     $instance = new static;

    //     $instance->config = $overrides;

    //     $disk = $instance->getDiskInstance($first_time);

    //     try {

    //       $disk->getAdapter()->getConnection();

    //     } catch (\LogicException $e) {
    //         // dd($e->getMessage());
    //       return false;

    //     }

    //     $website_folder = basename($instance->config->root);

    //     if ($first_time AND !$disk->has($website_folder)) {

    //       return $disk->createDir($website_folder);

    //     }

    //     return true;

    // }

    // /**
    //   * buildCSS
    //   *
    //   * builds css files out of the settings
    //   */
    // public function buildCss()
    // {

    //     $parser = new Less_Parser(config('less'));

    //     $parser->parseFile(config('less.less_path'));

    //     $parser->ModifyVars([
    //         'color-theme-primary'=> $this->settings('color_primary'),
    //         'color-theme-secondary' => $this->settings('color_secondary'),
    //     ]);

    //     return $parser->getCss();

    // }

    // /*
    // * Store an image as the website logo
    // *
    // */
    // public function addLogo(UploadedFile $file)
    // {

    //     // TODO vvvv BULLCRAP, move it to a separate method
    //     $connection_info = array_replace(Config::get('filesystems.disks.sftp'), (array) $this->config);

    //     Config::set('filesystems.disks.'.config('app.default_storage'), $connection_info);

    //     $photo = Photo::store($file, Auth::user(), [
    //         'storage' => $this->site_url,
    //         'file_path' => 'images/',
    //         'name' => 'logo',
    //     ], $this->getDiskInstance());

    //     if (!config('app.skip_alt_logo')) {
    //         $photo_original_path = $connection_info['root'].$photo->attributes['path'];

    //         // Now lets create the alternate png version.
    //         // get file size.
    //         $sizeCheck = new Imagick($photo_original_path);
    //         $size = $sizeCheck->getImageGeometry();

    //         // lets create the png version
    //         $image = new Imagick();
    //         $image->setResolution(4096, 4096);
    //         $image->setBackgroundColor(new ImagickPixel('transparent'));
    //         $image->readImageBlob(file_get_contents($photo_original_path));
    //         $image->setImageFormat("png32");
    //         $image->writeImage($connection_info['root'].str_replace('.svg', '.png', $photo->attributes['path']));
    //     }


    //     $this->logo()->delete();

    //     return $this->logo()->save($photo);
    // }

    // /**
    //  * Check if current website has a logo
    //  */
    // public function hasLogo()
    // {
    //     return $this->logo()->exists();
    // }

    // /**
    // *
    // * Website::first()->render()
    // *
    // *
    // */
    // public function renderPage($page_path)
    // {

    //     try {

    //         $page = $this->pages()
    //             ->where('slug', $page_path)
    //             ->firstOrFail();

    //     if ($page->checkPermissions(Auth::user())) {
    //         return $page;
    //     }

    //     } catch (ModelNotFoundException $e ) {

    //         return false;

    //     }

    //     return false;
    // }
    // /**
    //  *
    //  */
    // public function storeRedirects()
    // {

    //     $rendered = Redirect::renderForWebsite($this);

    //     $disk = $this->getDiskInstance();

    //     if (!$disk->put('nginx-redirects.conf', $rendered)) {

    //         abort(503);

    //     }
    //     return true;
    // }
}
