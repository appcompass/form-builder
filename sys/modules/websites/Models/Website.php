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

    /**
     * Pages
     *
     * @return     hasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Menus
     *
     * @return     hasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}