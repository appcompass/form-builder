<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;

class Website extends Model
{

    protected $fillable = [
        'name',
        'url'
    ];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}