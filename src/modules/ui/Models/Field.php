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
        'config',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    public function sections()
    {
        return $this->belongsToMany('Sections','field_section');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class,'field_fields','field_id','sub_field_id');
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

    public function build()
    {
        if ($this->pivot->count()) {
            return [
                'type' => $this->type,
                'config' => $this->pivot->config,
                'name' => $this->pivot->name,
                'label' => $this->pivot->label,
                'placeholder' => $this->pivot->placeholder,
                'attributes' => json_decode($this->pivot->field_attributes),
                'help_block' => $this->pivot->help_block,
            ];
        }

    }
}
