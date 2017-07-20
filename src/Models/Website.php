<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\Exception\NotFoundException;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\Redirect;
use P3in\Models\Section;
use P3in\Renderers\WebsiteRenderer;
use P3in\Traits\HasGallery;
use P3in\Traits\HasJsonConfigFieldTrait;
use P3in\Traits\HasPermission;
use P3in\Traits\HasStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Website extends Model
{
    use HasGallery,
        HasPermission,
        HasStorage,
        SoftDeletes,
        HasJsonConfigFieldTrait;

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

    // protected $hidden = ['config'];

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
     * Pages
     *
     * @return     hasMany
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Pages
     *
     * @return     hasMany
     */
    public function layouts()
    {
        return $this->hasMany(Layout::class);
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

    // public function logo()
    // {
    //     return $this->morphOne(Photo::class, 'photoable');
    // }

    public function builder()
    {
        return new WebsiteBuilder($this);
    }

    public function renderer()
    {
        return new WebsiteRenderer($this);
    }

    public function apendStoragePath()
    {
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
     *  Link a layout
     *
     */
    public function addLayout(Layout $layout)
    {
        $this->layouts()->save($layout);

        return $layout;
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
     * Gets the url attribute.
     *
     * @return     <type>  The url attribute.
     */
    public function getUrlAttribute()
    {
        return $this->attributes['scheme'].'://'.$this->attributes['host'];
    }

    /**
      * return admin
      *
      */
    public function scopeAdmin($query)
    {
        return $query->where('host', '=', env('ADMIN_WEBSITE_HOST'))->firstOrFail();
    }

    /**
      * return all but admin
      *
      */
    public function scopeManaged($query)
    {
        return $query->where('host', '!=', env('ADMIN_WEBSITE_HOST'));
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
        return strtolower(str_replace(' ', '_', 'website '.$this->attributes['name'].' id '.$this->getKey()));
    }

    public function getPageFromUrl($url)
    {
        try {
            return $this->pages()->byUrl($url)->firstorFail();
        } catch (Exception $e) {
            throw new Exception('There is no page by that URL.');
        }
    }

    public static function fromRequest(Request $request, $host = null)
    {
        $host = $host ?? $request->header('Site-Host');
        try {
            return self::whereHost($host)->firstOrFail();
        } catch (NotFoundException $e) {
            App::abort(401, $host.' Not Authorized');
        } catch (ModelNotFoundException $e) {
            App::abort(401, $host.' Not Authorized');
        }
    }
}
