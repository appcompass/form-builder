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

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function parent()
    {
        return $this->belongsTo(Page::class);
    }
}