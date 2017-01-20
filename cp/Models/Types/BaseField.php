<?php

namespace P3in\Models\Types;

use P3in\Models\Field;

abstract class BaseField
{
    public $template;

    public $field;

    public static function make($label, $name)
    {
        $instance = new static();

        // @TODO add setField to close access to property
        $instance->field = Field::firstOrCreate([
            'label' => $label,
            'name' => $name,
            'type' => get_class($instance)
        ]);

        return $instance;
    }

    public function template()
    {
        // @TODO template can be inferred from class name
        return file_get_contents(__DIR__ . '/../templates/' . $this->template . '.vue');
    }

}
