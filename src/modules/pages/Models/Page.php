<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use P3in\ModularBaseModel;
use P3in\Models\PageSection;
use P3in\Models\Section;
use P3in\Models\Website;
use P3in\Traits\NavigatableTrait as Navigatable;
use P3in\Traits\SettingsTrait;

class Page extends ModularBaseModel
{

    use SettingsTrait, Navigatable;

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
        'order',
        'active',
        'layout',
        'req_permission',
        'published_at',
    ];

    /**
    *   Fields that needs to be treated as a date
    *
    */
    protected $dates = ['published_at'];

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
        return array_replace([
            "label" => $this->title,
            "url" => $this->slug,
            "req_perms" => null,
            "props" => [
                'icon' => 'list',
                "link" => [
                    'href' => $this->slug,
                    'data-target' => '#main-content-out'
                ],
            ]
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

    public function not_clone()
    {
        $original = $this->load('content');
        $settings = $original->settings()->first();

        $new = $original->replicateWithRelations();

        $new->title = $original->title.' (copy)';

        $new->slug = $original->slug.'-copy';

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

        $this->load('settings');

        $views['website'] = $website;
        $views['page'] = $this;
        $view['breadcrumbs'] = $this->breadcrumbs();

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


            // dd($pageSections);
            foreach($pageSections as $pageSection) {
                $views[$pageSection->section][] = $pageSection->render();
            }
        }

        $views['navmenus'] = [];

        $navmenus = $website->navmenus()
            ->whereNull('parent_id')
            ->get();

        foreach ($navmenus as $navmenu) {
            $navmenu->load('items');

            $views['navmenus'][$navmenu->name] = $navmenu->toArray();

            $views['navmenus'][$navmenu->name]['children'] = [];

            foreach($navmenu->children as $child) {

                $views['navmenus'][$navmenu->name]['children'][$child->id] = $child;

            }


        }

        $views['navmenus'] = json_decode(json_encode($views['navmenus']));


        return $views;

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
        $escaped_slug = DB::raw($escaped_url);

        $query
            ->select(
                "*",
                DB::raw("NULLIF(substring($escaped_url from slug), slug) AS dynamic_segment")
            )
            ->where($escaped_slug,'SIMILAR TO', DB::raw('slug'));
    }

    /**
     *
     *
     *
     */
    public function getFullUrlAttribute()
    {
            $slug = $this->dynamic_segment ? str_replace('([a-z0-9-]+)', $this->dynamic_segment, $this->slug) : $this->slug;
            return rtrim($this->website->site_url,'/').'/'.trim($slug,'/');
    }

    public function getUrlAttribute()
    {
            $slug = $this->dynamic_segment ? str_replace('([a-z0-9-]+)', $this->dynamic_segment, $this->slug) : $this->slug;
            return '/'.trim($slug,'/');
    }

    /**
     *
     *
     */
    public function byPath($path, User $user)
    {

        try {

            $page = Page::findOrFail($path);

            $this->checkPermissions($user);

        } catch (ModelNotFoundException $e ) {

            return false;

        }

    }

    /**
     * Check if User has permissions
     *
     *
     */
    public function checkPermissions(User $user = null)
    {

        $this->req_permission = is_array($this->req_permission) ? $this->req_permission : explode(",", $this->req_permission);


        if (count($this->req_permission)) {

            if (is_null($user)) {

                return false;

            }

            return $user->hasPermissions($this->req_permission);

        }

        return true;

    }

}
