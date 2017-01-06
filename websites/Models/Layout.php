<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;
use P3in\Models\Section;

class Layout extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}