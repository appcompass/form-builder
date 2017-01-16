<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use P3in\Models\Layout;
use P3in\Models\PageContent;
use P3in\Models\Section;
use P3in\Models\Website;
use P3in\Traits\HasPermissions;
use P3in\Traits\SettingsTrait;
use P3in\Interfaces\Linkable;

class Page extends Model implements Linkable
{
    use SoftDeletes
        // , HasPermissions
        ;

    protected $fillable = [
        'slug',
        'title',
        'meta'
    ];

    protected $guarded = [
        'url', // url are ALWAYS gonna be generated
    ];

    protected $casts = [
        'meta' => 'object'
    ];

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

    public function layouts()
    {
        return $this->belongsToMany(Layout::class)
            ->withPivot('order')
            ->orderBy('pivot_order', 'asc');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function contents()
    {
        return $this->hasMany(PageContent::class)->orderBy('order', 'asc');
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
            ->where($raw_url, 'SIMILAR TO', DB::raw('url'));
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
     * updateChildrenUrl
     *
     *  Updates children's url
     *
     */
    private function updateChildrenUrl()
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
     * Makes a menu item.
     *
     * @return     MenuItem
     */
    public function makeMenuItem($order = 0): MenuItem
    {
        $item = new MenuItem([
            'title' => $this->title,
            'alt' => $this->title,
            'order' => $order,
            'new_tab' => false,
            'url' => $this->url, // isn't this null? more over, isn't this field not supposed to exist here? All links come from the model now.
            'clickable' => true,
            'icon' => null
        ]);

        $item->navigatable()->associate($this);

        return $item;
    }
}
