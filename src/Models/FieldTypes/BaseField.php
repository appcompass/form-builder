<?php

namespace AppCompass\Models\FieldTypes;

use AppCompass\Models\Field;
use AppCompass\Models\Form;
use AppCompass\Models\Fieldtype;

abstract class BaseField
{
    protected $template;

    protected $name;

    public $field;

    public static function make($label, $name, Form $form)
    {
        $instance = new static();

        // types are handled by the Fieldtype
        $type = Fieldtype::make($instance);

        $field = Field::create([
            'label' => $label,
            'name' => $name,
            'type' => $type,
            'form_id' => $form->id
        ]);

        $instance->field = $field;

        return $instance;
    }

    public function getName()
    {
        return $this->name ?: $this->template;
    }

    public function getTemplate()
    {
        return $this->template . '.vue';
    }
}
