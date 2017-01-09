<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\BlogCategory;
use P3in\Models\BlogPost;
use P3in\Models\Website;
use P3in\ModularBaseModel;

class BlogCategory extends ModularBaseModel
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blog_categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
	];

	/**
	*	Fields that needs to be treated as a date
	*
	*/
	protected $dates = [];

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * scopeOfWebsite
     * if $website is passed, then we look up that website's blog entr(y|ies).
     * Otherwise we use the current website.
     */
    public function scopeOfWebsite($query, Website $website = null)
    {
        $website = $website ?: Website::current();

        return $query->whereHas('website',function($q) use ($website) {

            $q->where('id', $website->id);

        });
    }

    public function getUrlAttribute()
    {
        return '/blog/category/'.$this->attributes['slug'];
    }
}
