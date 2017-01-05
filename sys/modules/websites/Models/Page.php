<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;

class Page extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        // 'website_id'
    ];

    protected $guarded = [
        'url', // url are ALWAYS gonna be generated
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

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    // public function sections()
    // {
    //     return $this->belongsToMany(Section::class);
    // }

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
        foreach($this->children as $child) {

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

        while($page->parent_id !== NULL) {

            array_push($slugs, $page->slug);

            $page = $page->parent;

        }

        return '/' . implode('/', array_reverse($slugs));
    }


}
