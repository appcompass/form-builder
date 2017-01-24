<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use P3in\Interfaces\Linkable;
use P3in\Models\Layout;
use P3in\Models\PageComponentContent;
use P3in\Models\Component;
use P3in\Models\Website;

class Page extends Model implements Linkable
{
    use SoftDeletes
    // , HasPermissions
    ;

    protected $fillable = [
        'slug',
        'title',
        'meta',
    ];

    protected $guarded = [
        'url', // url are ALWAYS gonna be generated
    ];

    protected $casts = [
        'meta' => 'object',
    ];

    /**
     * website
     *
     * @return     BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * parent
     *
     * @return     BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    /**
     * children
     *
     * @return     HasMany
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Page Components
     *
     * @return     BelongsToMany
     */
    public function components()
    {
        return $this->belongsToMany(Component::class, 'page_component_content');
    }

    /**
     * content
     *
     * @return     HasMany
     */
    public function containers()
    {
        return $this->hasMany(PageComponentContent::class)->orderBy('order', 'asc');
    }


    /**
     * So this is here temporarily (unless we end up liking it) to allow us to
     * fetch only the top level containers of a page. This is because as of
     * right now, all PageComponentContent instances have a page_id, even if
     * it is a child of another PageComponentContent, so when querying a page,
     * it's contents, and the associated components, you get a a lot of
     * redundant data.  This method lets us recursivly fetch the whole tree
     * without having to build a tree builder, and without removing page_id from
     * the PageComponentContent instances that are sections (children of containers)
     * @return hasMany
     */
    // public function containers()
    // {
    //     return $this->hasMany(PageComponentContent::class)
    //     ->orderBy('order', 'asc')
    //     ->whereHas('component', function ($query) {
    //         $query->where('type', 'container');
    //     })->whereNull('parent_id');
    // }

    /**
     * get the Page via it's url
     *
     * @param      <type>  $query  The query Builder instance
     * @param      <type>  $url    The url
     *
     * @return     Builder
     */
    public function scopeByUrl($query, $url)
    {
        $escaped_url = DB::connection()->getPdo()->quote($url);
        $raw_url = DB::raw($escaped_url);

        return $query
            ->select(
                "*",
                DB::raw("NULLIF(substring($escaped_url from url), url) AS dynamic_segment")
            )
            ->where($raw_url, 'SIMILAR TO', DB::raw('url'));
    }

    /**
     * Add a Container to the page.
     *
     * @param      int    $columns
     * @param      int    $order
     *
     * @return     Model  PageComponentContent
     */
    public function addContainer($columns, $order)
    {
        //I have no idea why they don't have a ->new() method...
        $container = $this->containers()->findOrNew(null);

        $container->saveAsContainer($columns, $order);

        return $container;
    }

    /**
     * Sets the url based on slug
     *
     * @param      <type>  $slug   The slug
     */
    public function setSlugAttribute($slug)
    {
        $this->attributes['slug'] = $slug;

        $this->attributes['url'] = $this->buildUrl();

        if ($this->exists) {
            $this->save();

            $this->updateChildrenUrl();
        }
    }

    /**
     * Gets the component name attribute.
     *
     * @return     <type>  The component name attribute.
     */
    public function getComponentNameAttribute()
    {
        $url = $this->url == '/' ? 'Home' : $this->url;
        return studly_case(str_slug(str_replace('/', ' ', $url)));
    }

    /**
     * Gets the full url attribute.
     *
     * @return     <type>  The full url attribute.
     */
    public function getFullUrlAttribute()
    {
        return $this->website->url.$this->url;
    }

    /**
     * Gets the update frequency attribute.
     *
     * @return     <type>  The update frequency attribute.
     */
    public function getUpdateFrequencyAttribute()
    {
        return $this->getMeta('update_frequency');
    }

    /**
     * Gets the priority attribute.
     *
     * @return     <type>  The priority attribute.
     */
    public function getPriorityAttribute()
    {
        return $this->getMeta('priority');
    }

    /**
     * Gets the images attribute.
     *
     * @return     array  The images attribute.
     */
    public function getImagesAttribute() // for sitemap.
    {
        $images = [];
        $page_title = $this->title;
        // construct an array of images like: $images[] = ['url' => 'http://path.to.image', 'title' => $page_title.' Image Name or Alt text']

        return $images;
    }

    /**
     * Sets the meta.
     *
     * @param      <type>  $key    The key
     * @param      <type>  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setMeta($key, $val)
    {
        $this->update(['meta->'.$key => $val]);

        return $this;
    }

    /**
     * Gets the meta.
     *
     * @param      <type>  $key    The key
     *
     * @return     <type>  The meta.
     */
    public function getMeta($key)
    {
        return isset($this->meta->{$key}) ? $this->meta->{$key} : null;
    }

    /**
     * updateChildrenUrl
     *
     *  Updates children's url
     *
     */
    public function updateChildrenUrl()
    {
        foreach ($this->children as $child) {
            $child->url = $child->buildUrl();

            $child->save();
        }
    }

    /**
     * buildUrl
     *
     * @return     string   Full Url, including parents
     */
    private function buildUrl()
    {
        $page = $this;

        $slugs = [$this->slug];

        while ($page->parent_id !== null) {
            $page = $page->parent;

            array_push($slugs, $page->slug);
        }

        return '/' . implode('/', array_reverse($slugs));
    }

    /**
     * Creates a child.
     *
     * @param      <type>  $data   The data
     *
     * @return     static  ( description_of_the_return_value )
     */
    public function createChild($data)
    {
        $page = new static;

        $page->parent()->associate($this);
        $page->website()->associate($this->website);

        // the order of this is due to needing the parent to be defined before the slug.
        $page->fill($data);

        $page->save();

        return $page;
    }

    /**
     * Makes a menu item.
     *
     * @return     MenuItem
     */
    public function makeMenuItem($order = 0): MenuItem
    {

        // @TODO find a way to auto-determine order based on previous insertions

        $item = new MenuItem([
            'title' => $this->title,
            'alt' => $this->title,
            'order' => $order,
            'new_tab' => false,
            'url' => null,
            'clickable' => true,
            'icon' => null,
        ]);

        $item->navigatable()->associate($this);

        return $item;
    }
}
