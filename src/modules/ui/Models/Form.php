<?php

namespace P3in\Models;

use P3in\Models\Field;
use P3in\ModularBaseModel;

class Form extends ModularBaseModel
{
    protected $fillable = [
        'name',
        'config',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    protected $with = [
        'fields'
    ];

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'form_fields')->withPivot('label', 'name', 'placeholder', 'help_block', 'field_attributes', 'order')->orderBy('order');
    }

    public function build()
    {
        $rtn = [
            'config' => $this->config,
            'fields' => [],
        ];
        foreach ($this->fields as $field) {
            $rtn['fields'][] = $field->build();
        }

        return $rtn;
    }
}
