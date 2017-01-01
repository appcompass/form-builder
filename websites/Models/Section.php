<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;

class Page extends Model
{

    protected $fillable = [
        'name',
        'title',
        'description',
        'slug',
        'url',
        'layout'
    ];

    public function page()
    {
        return $this->belongsToMany(Page::class);
    }

}