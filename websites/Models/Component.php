<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Form;
use P3in\Models\Page;

class Component extends Model
{
    protected $fillable = [
        'name',
        'template',
        'type',
        'config',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_component_content');
    }

    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }

    public function scopeGetType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function getContainer()
    {
        return static::getType('container')->firstOrFail();
    }
}
