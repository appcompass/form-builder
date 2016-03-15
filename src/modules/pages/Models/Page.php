<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use P3in\Models\PageSection;
use P3in\Models\Section;
use P3in\Models\Website;
use P3in\ModularBaseModel;
use P3in\Traits\NavigatableTrait as Navigatable;
use P3in\Traits\SettingsTrait;
use P3in\Traits\HasPermissions;

class Page extends ModularBaseModel
{

    use SettingsTrait, Navigatable, HasPermissions;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'description',
        'slug',
        'url',
        'order',
        'active',
        'layout',
        'published_at',
    ];

    /**
    *   Fields that needs to be treated as a date
    *
    */
    protected $dates = ['published_at'];


    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function hasParent()
    {
        return !empty($this->parent->id);
    }
    public function getUrl()
    {
        $tree = $this->withParents()->orderBy('level', 'desc')->get();
        $url = '';
        foreach ($tree as $page) {
            if (!empty($page->slug)) {
                $url .= '/'.$page->slug;
            }
        }
        if (!empty($this->settings->data->config->dynamic) && $this->settings->data->config->dynamic == true) {
            $url .= '/([a-z0-9-]+)';
        }
        return trim($url,'/');
    }
    /**
     *
     */
    public function sections($type = null)
    {

        $rel = $this->belongsToMany(Section::class)
            ->withPivot(['id', 'order', 'content', 'type'])
            ->orderBy('order', 'asc');

        if (!is_null($type)) {

            $rel->wherePivot('type', $type);

        } else {

            $rel->wherePivot('type', null);

        }

        return $rel;

    }

    /**
     *
     */
    public function content()
    {
        // should probably split the template type and provide it divided? we'll see
        return $this->hasMany(PageSection::class)->orderBy('order', 'asc');
    }

    /**
     *  Build a LinkClass out of this class
     */
    public function makeLink($overrides = [])
    {
        $req_perm = $this->getRequiredPermission()->first();

        return array_replace([
            "label" => $this->title,
            "url" => $this->slug,
            "req_perms" => $req_perm ? $req_perm->id : Permission::GUEST_PERMISSION,
            "props" => ['icon' => 'list']
        ], $overrides);
    }

    /**
     *  Get the website the page belongs to
     *
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     *  Link the page to a website
     *
     */
    public function linkToWebsite(Website $website)
    {
        return $this->website()
            ->associate($website)
            ->save();
    }

    public function cloneRecord()
    {
        $original = $this->load('content');
        $settings = $original->settings()->first();

        $new = $original->replicateWithRelations();

        $new->title = $original->title.' (copy)';

        $new->slug = $original->slug.'-copy';

        $new->url = $original->url.'-copy';

        $new->push();

        if (!empty($settings->data)) {
            $new->settings((array) $settings->data);
        }

        return $new;

    }

    /**
     * Render the page
     *
     */
    public function render($code = 200)
    {

        $views = [];

        $website = Website::current();

        $globals = Section::whereIn('id',[$website->settings('header'), $website->settings('footer')])->get();

        $this->with('settings');

        $page_meta_data = $this->settings('meta_data');

        $views['website'] = $website;
        $views['page'] = $this;
        $views['breadcrumbs'] = $this->breadcrumbs();

        if (!empty($website->settings->data->meta_data)) {
            foreach ($website->settings->data->meta_data as $key => $val) {
                $views['meta_data'][$key] = $val;
            }
        }

        if (!empty($page_meta_data)) {
            foreach ($page_meta_data as $key => $val) {
                $views['meta_data'][$key] = $val;
            }
        }

        $views['settings'] = $this->settings->data;

        $views['files'] = [
            'css_file' => $website->settings('css_file'),
            'js_file' => $website->settings('js_file'),
        ];

        foreach ($globals as $global) {
            $views[$global->type] = [
                'view' => '/sections'.$global->display_view,
                // 'data' => $global->pivot->content // TODO MUST LINK SECTION ON WEBSITE SETTINGS STORAGE
            ];
        }
        if ($code == 200) {
            $pageSections = $this->content()->with('template')->get();

            foreach($pageSections as $pageSection) {
                $views[$pageSection->section][] = $pageSection->render();
            }
        }

        $views['navmenus'] = [];

        $navmenus = $website->navmenus()
            ->whereNull('parent_id')
            ->with('navitems')
            ->get();

        $views['navmenus'] = $navmenus;

        $views['navmenus']['main_nav'] = $navmenus->where('name', $website->getMachineName() . '_main_nav')->first();

        $views['navmenus']['footer'] = $navmenus->where('name', $website->getMachineName() . '_footer_nav')->first();


        return $views;

    }

    /**
     * Matches passed type agai
     */
    public function type($type)
    {
        return preg_match('/'.$type.'/i', $this->name);
    }

    /**
     * breadcrumb rendering function
     *
     * @return array
     * @author Jubair Saidi
     **/
    public function breadcrumbs($end = null)
    {
        $rtn = $this->withParents()->orderBy('level', 'desc')->get();
        if ($end) {
            $end->current = true;
            $rtn->add($end);
        }

        // $rtn->each(function($rec){
        //     $rec->current = true;
        // });

        return $rtn;
    }

    /**
     * scope for fetching a page and it's parents
     *
     * @return QueryBuilder
     * @author
     **/
    public function scopeWithParents($query)
    {
        $page_id = !empty($this->id) ? $this->id : $page_id;

        $escaped_page_id = DB::connection()->getPdo()->quote($page_id);
        $p_id = DB::raw($escaped_page_id);

        $query->select("pages.*", "p2.level")->join(DB::raw("(WITH RECURSIVE pages_tree AS (SELECT id, parent_id, 1 AS level
                    FROM pages
                    WHERE id = $p_id
                    UNION ALL
                    SELECT c.id, c.parent_id, p.level + 1
                    FROM pages c
                    JOIN pages_tree p ON c.id = p.parent_id)
                SELECT *
                FROM pages_tree) as p2"), function($join){
            $join->on('p2.id', '=', 'pages.id');
        })->whereNotNull('level');

        return $query;
    }
    /**
     * scopeOfWebsite
     * if $website is passed, then we look up that website's pages.
     * Otherwise we use the current website.
     */
    public function scopeOfWebsite($query, Website $website = null)
    {
        $website = $website ?: Website::current();

        if (is_null($website)) {
            throw new \Exception("Website not defined");
        }
        return $query->whereHas('website',function($q) use ($website) {

            $q->where('id', $website->id);

        });
    }

    public function scopeByUrl($query, $url)
    {
        $escaped_url = DB::connection()->getPdo()->quote($url);
        $raw_url = DB::raw($escaped_url);

        return $query
            ->select(
                "*",
                DB::raw("NULLIF(substring($escaped_url from url), url) AS dynamic_segment")
            )
            ->where($raw_url,'SIMILAR TO', DB::raw('url'));
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeIsNot($query, $id)
    {
        return $query->where('id', '!=', $id);
    }

    /**
     *
     *
     *
     */
    public function getFullUrlAttribute()
    {
        $url = $this->dynamic_segment ? str_replace('([a-z0-9-]+)', $this->dynamic_segment, $this->url) : $this->url;
        return $this->website->site_url.'/'.$url;
    }

    public function getUrlAttribute()
    {
        return $this->dynamic_segment ? str_replace('([a-z0-9-]+)', $this->dynamic_segment, $this->attributes['url']) : $this->attributes['url'];
    }

    public function getImagesAttribute()
    {
        $images = [];
        $page_title = $this->title;
        $page = json_decode($this->toJson(),true);
        array_walk_recursive($page, function($value, $key) use (&$images, $page_title){
            if ($key == 'image') {
                $images[] = ['url' => URL::to($value), 'title' => $page_title.' - '.$value];
            }
        });
        return $images;
    }

    public function getUpdateFrequencyAttribute()
    {
        return 'daily'; //this needs to be dynamically set.
    }

    public function getPriorityAttribute()
    {
        return '1.0'; // this needs to be dynamically set.
    }

    /**
     *
     *
     */
    public function byPath($path, User $user)
    {

        try {

            $page = Page::findOrFail($path);

        } catch (ModelNotFoundException $e ) {

            return false;

        }

    }
}
