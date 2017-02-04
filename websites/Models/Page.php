<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use P3in\Interfaces\Linkable;
use P3in\Models\Layout;
use P3in\Models\PageSectionContent;
use P3in\Models\Section;
use P3in\Models\Website;
use Exception;

class Page extends Model implements Linkable
{
    use SoftDeletes
    // , HasPermissions
    ;

    // used for page output structuring.
    private $build = [];

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

    // public $appends = ['type', 'head_meta'];

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
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'page_section_content');
    }

    /**
     * content
     *
     * @return     HasMany
     */
    public function contents()
    {
        return $this->hasMany(PageSectionContent::class)->orderBy('order', 'asc');
    }

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
     * @param      int    $order
     * @param      array    $config
     *
     * @return     Model  PageComponentContent
     */
    public function addContainer(int $order, array $config = null)
    {
        //I have no idea why they don't have a ->new() method...
        $container = $this->contents()->findOrNew(null);

        $container->saveAsContainer($order, $config);

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
     * Gets the template name attribute.
     *
     * @return     <type>  The template name attribute.
     */
    public function getTemplateNameAttribute()
    {
        $url = $this->url == '/' ? 'Home' : $this->url;
        return studly_case(str_slug(str_replace('/', ' ', $url)));
    }

    public function getHeadMetaAttribute()
    {
        // }, {
        //   "http-equiv": "x-ua-compatible", content: "ie=edge"
        // }, {
        //   name: "viewport", content: "width=device-width, initial-scale=1"
        // }, {
        //   hid: "description", content: "Plus 3 Interactive, LLC"
        //   { hid: 'description', name: 'description', content: 'Home page description' }
        // { hid: 'description', name: 'description', content: 'Home page description' }
        $rtn = [];
        foreach ($this->meta->head as $name => $head) {
            $rtn[] = [
                'hid' => $name,
                'name' => $name,
                'content' => $head
            ];
        }
        return $rtn;
    }
    /**
     * Menu Handling
     *
     * @return     <type>  The type attribute.
     */
    public function getTypeAttribute()
    {
        return 'Page';
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

    // page contents and sections rendering methods
    private function buildContentBranches($parent_id)
    {
        $branches = [];
        foreach ($this->contents as $row) {
            if ($row->parent_id == $parent_id) {
                $row->children = $this->buildContentBranches($row->id);
                $branches[] = $row;
            }
        }
        return collect($branches);
    }

    public function buildContentTree($with_sections = false)
    {
        if ($with_sections) {
            $this->contents->load('section');
        }
        $tree = [];
        foreach ($this->contents as $row) {
            if (is_null($row->parent_id)) {
                $row->children = $this->buildContentBranches($row->id);
                $tree[] = $row;
            }
        }
        return $tree;
    }

    public function getData($filtered = true)
    {
        if ($filtered) {
            $this->filterData();
        }

        $this->getContent($this->buildContentTree());

        $this->build['page'] = $this;

        // $this->getSettings();
        // $this->getContent($filtered);

        // structure the page data to be sent to the front-end to work out.
        return $this->build;
    }

    private function getContent($sections)
    {
        foreach ($sections as $row) {
            if ($row->children->count()) {
                $this->getContent($row->children);
            } else {
                $this->build['content'][$row->id] = $row->content;
            }
        }
    }

    private function filterData()
    {
        $this
            ->makeHidden('id')
            ->makeHidden('website_id')
            ->makeHidden('dynamic_url')
            ->makeHidden('created_at')
            ->makeHidden('deleted_at')
            ->makeHidden('dynamic_segment')
            ->makeHidden('contents')
        ;
    }
}
