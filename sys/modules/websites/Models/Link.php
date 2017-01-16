<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\Linkable;
use P3in\Models\MenuItem;
use Validator;
use Exception;

class Link extends Model implements Linkable
{
    protected $fillable = [
        'title',
        'url',
        'alt',
        'new_tab',
        'clickable',
        'icon'
    ];

    private $rules = [
        'title' => 'required',
        'url' => 'required_if:clickable,true',
        'alt' => 'required',
        'new_tab' => 'required',
        // 'clickable' => ''
    ];

    public function makeMenuItem(): MenuItem
    {
        return MenuItem::create([
            'title' => $this->title,
            'alt' => $this->alt,
            'new_tab' => $this->new_tab,
            'url' => $this->url,
            'clickable' => $this->clickable,
            'icon' => $this->icon
        ]);
    }
}
