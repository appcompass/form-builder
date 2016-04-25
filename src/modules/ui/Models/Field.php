<?php

namespace P3in\Models;

use P3in\Models\Form;
use P3in\ModularBaseModel;

class Field extends ModularBaseModel
{
    protected $fillable = [
        'type',
        'name',
        'source',
        'data',
        'config',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'object',
        'config' => 'object',
    ];

    protected $with = [
        'fields'
    ];

    public function sections()
    {
        return $this->belongsToMany('Sections','field_section');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class,'field_fields','field_id','sub_field_id')->withPivot('order')->orderBy('order', 'asc');
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class,'form_fields');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type)->first();
    }
}
