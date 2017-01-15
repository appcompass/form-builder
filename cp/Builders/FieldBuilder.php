<?php

namespace P3in\Builders;

use Closure;
use P3in\Models\Field;
use P3in\Traits\HasFieldsTrait;

class FieldBuilder
{
    use HasFieldsTrait;
    /**
     * Field instance
     */
    public $field;

    public function __construct(Field $field = null)
    {
        if (!is_null($field)) {
            $this->setField($field);
        }

        return $this;
    }

    private function setField($field)
    {
        $this->field = $field;
        $this->setFieldParent($field);
    }

    /**
     * Gets the name.
     *
     * @param      <type>  $name   The name
     *
     * @return     <type>  The name.
     */
    public function getName($name = null)
    {
        return $this->field->name;
    }

    /**
     * Sets the name.
     *
     * @param      <type>  $name   The name
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setName($name)
    {
        $this->field->name = $name;

        $this->field->save();

        return $this;
    }
}
