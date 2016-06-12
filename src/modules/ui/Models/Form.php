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

    private $processed_fields = [];

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'form_fields')->withPivot('label', 'name', 'placeholder', 'help_block', 'field_attributes', 'belongs_to', 'config', 'order')->orderBy('order', 'asc');
    }

    public function build($field = null)
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if (!$field->pivot->belongs_to) {
                $fields[] = $this->populateField($field);
            }
        }
        // dd([
        //     $this->fields->toArray(),
        //     'config' => $this->config,
        //     'fields' => $fields,
        // ]);
        return json_decode(json_encode([
            'config' => $this->config,
            'fields' => $fields,
        ]));
    }

    private function populateField($parent_field, $check = false)
    {
        $pivot = $parent_field->pivot;

        $this->processed_fields[] = $parent_field;

        $rtn = [];
        $data = [];

        if ($parent_field->data) {

            $data = $parent_field->data;

        }elseif($parent_field->source){

            $data = with(new $parent_field->source)->populateField($parent_field->name);

        }elseif($parent_field->fields->count()){

            foreach ($parent_field->fields as $sub_field) {
                $search = array_where($this->fields, function($key, $value) use ($sub_field, $check)
                {
                    return $value->name == $sub_field->name && !in_array($value, $this->processed_fields);
                });
                if ($found = head($search)) {
                    $data[] = $this->populateField($found);
                }
            }

        }

        return [
            'type' => $parent_field->type,
            'config' => json_decode($pivot->config),
            'name' => $pivot->name,
            'label' => $pivot->label,
            'placeholder' => $pivot->placeholder,
            'attributes' => json_decode($pivot->field_attributes),
            'data' => $data,
            'help_block' => $pivot->help_block,
        ];
    }
}
