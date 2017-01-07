<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use P3in\Models\Page;
use P3in\Traits\SettingsTrait;

class Website extends Model
{

    use SettingsTrait,
        // Navigatable,
        // HasPermissions,
        SoftDeletes;

    protected $fillable = [
        'name',
        'url'
    ];

    protected $casts = [
        'config' => 'object'
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