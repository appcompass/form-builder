<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Exception;

class Link extends Model
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
}
