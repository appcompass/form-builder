<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;
use P3in\Traits\FormableTrait;

class Plus3Person extends Model
{
    protected $fillable = [
        'title',
        'meta_keywords',
        'meta_description',
        'bio',
        'instagram_link',
        'twitter_link',
        'facebook_link',
        'linkedin_link',
    ];

    // @TODO find a way around this if possible.  not a fan of using $with on a global level.
    // i.e. include it as an option for the Dynamic field type.
    protected $with = [
        'user',
    ];

    protected $appends = [
        'full_name',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->full_name;
    }

    public function getSlugAttribute()
    {
        return str_slug($this->full_name);
    }
}
