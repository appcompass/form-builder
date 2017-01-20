<?php

namespace P3in\Models\Types;

use P3in\Models\Field;

abstract class BaseField
{
    public $template;

    public $field;

    public static function make(array $attributes)
    {
        $instance = new static();

        $attributes['type'] = get_class($instance);

        $instance->field = Field::firstOrCreate($attributes);

        return $instance;
    }

    public function template()
    {
        // @TODO template can be inferred from class name
        return file_get_contents(__DIR__ . '/../templates/' . $this->template . '.vue');
    }

}
