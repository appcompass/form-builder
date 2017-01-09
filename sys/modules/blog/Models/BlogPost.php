<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\BlogCategory;
use P3in\Models\BlogTag;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\ModularBaseModel;
use Carbon\Carbon;

class BlogPost extends ModularBaseModel
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blog_posts';

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
	protected $dates = ['published_at'];


    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_posts_tags', 'post_id', 'tag_id');
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

    public function scopeOfCategoryBySlug($query, $slug)
    {
        return $query->whereHas('category',function($q) use ($slug) {

            $q->where('slug', $slug);

        });
    }

    public function scopeOfTagBySlug($query, $slug)
    {
        return $query->whereHas('tags',function($q) use ($slug) {

            $q->where('slug', $slug);

        });
    }

    public function getBlogEntries($filters, $url = '')
    {
        $qry = $this->with('author', 'category', 'tags')
            ->ofWebsite()
            ->orderBy('published_at', 'desc');

        $urlAry = explode('/', trim($url, '/'));

        if (!empty($urlAry[1]) && !empty($urlAry[2])) {
            switch ($urlAry[1]) {
                case 'category':
                    $qry->ofCategoryBySlug($urlAry[2]);
                    break;
                case 'tag':
                    $qry->ofTagBySlug($urlAry[2]);
                    break;
            }
        }
        return $qry->paginate(10);
    }

    public function getBlogEntry($slug)
    {
        return $this->with('author', 'category', 'tags')
            ->where('slug', $slug)
            ->ofWebsite()
            ->first();
    }

    public function getLatestEntries($count)
    {
        return $this->with('author', 'category', 'tags')
            ->ofWebsite()
            ->orderBy('published_at', 'desc')
            ->skip(0)
            ->take($count)
            ->get();
    }

    public function getUrlAttribute()
    {
        return '/blog/'.$this->attributes['slug'];
    }

    public function getPublishedAtAttribute()
    {
        return (new Carbon($this->attributes['published_at']))->format('M jS, Y');
    }

    public function getBaseUrlAttribute()
    {
        return '/blog/';
    }

}
