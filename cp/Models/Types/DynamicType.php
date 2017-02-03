<?php

namespace P3in\Models\Types;

use P3in\Models\FieldSource;
use P3in\Models\Form;

class DynamicType extends BaseField
{
    protected $template = 'Dynamic';

    protected $name = 'Dynamic';

    public static function make($label, $name, Form $form) {

        // we get the field instance
        $instance = parent::make($label, $name, $form);

        // set it to be dynamic
        $instance->field->update(['dynamic' => true]);

        // create a source
        $field_source = FieldSource::create([
            'linked_id' => $instance->field->id,
            'linked_type' => static::class,
            'data' => null,
            'criteria' => []
        ]);

        // and link it to the field
        // $instance->field->linked()->save($field_source);

        return $instance;
    }
}
