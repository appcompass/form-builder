<?php

namespace P3in\Models\Types;

use P3in\Models\Field;
use P3in\Models\Fieldtype;

abstract class BaseField
{
    protected $template;

    protected $name;

    public $field;

    public static function make($label, $name)
    {
        $instance = new static();

        // types are handled by the Fieldtype
        $type = Fieldtype::make($instance);

        // @TODO add setField to close access to property
        $instance->field = Field::firstOrCreate([
            'label' => $label,
            'name' => $name,
            'type' => $type
        ]);

        return $instance;
    }

    public function getName()
    {
        return $this->name ?: $this->template;
    }

    public function getTemplate()
    {
        return $this->template . '.vue';
        // @TODO template can be inferred from class name
        // return file_get_contents(__DIR__ . '/../templates/' . $this->template . '.vue');
    }
}
