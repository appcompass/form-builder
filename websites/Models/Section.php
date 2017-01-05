<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;

class Section extends Model
{

    protected $fillable = [
        'name',
        'fits',
        'display_view',
        'edit_view',
        'type',
        'config',
    ];

    public function page()
    {
        return $this->belongsToMany(Page::class);
    }

}