<?php

namespace P3in\Models\Types;

class MenuElementType extends BaseField
{

    protected $template = 'MenuElement';

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }

    public function string($label, $name = null, $validation = [])
    {
        return $this->addField($label, $name, 'string', $validation);
    }

}