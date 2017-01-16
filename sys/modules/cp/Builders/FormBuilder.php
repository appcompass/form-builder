<?php

namespace P3in\Builders;

use Closure;
use P3in\Models\Form;
use P3in\Traits\HasFieldsTrait;

class FormBuilder
{
    use HasFieldsTrait;

    /**
     * Form instance
     */
    public $form;

    public function __construct(Form $form = null)
    {
        if (!is_null($form)) {
            $this->setForm($form);
        }

        return $this;
    }

    /**
     * New a form
     *
     * @param      string  $name   Form Name
     * @param      string  $resource The resource the form points to
     * @param      Closure $closure called and receives the ResourceBuilder instance
     *
     * @return     static  Form Instance
     */
    public static function new($name, Model $parent, Closure $closure = null)
    {
        $instance = new static();

        $form = $parent->form()->create(['name' => $name]);

        $instance->setForm($form);

        if ($closure) {
            $closure($instance);
        }

        return $instance;
    }

    /**
     * Sets the form.
     *
     * @param      <type>  $form   The form
     */
    private function setForm($form)
    {
        $this->form = $form;

        $this->setFieldParent($form);
    }

    /**
     * Edit a form
     *
     * @param      string  $form   The form
     *
     * @return     static  ( description_of_the_return_value )
     */
    public static function edit($form)
    {
        if ($form instanceof Form) {
            $instance = new static($form);
        } elseif (is_string($form)) {
            $instance = new static(Form::whereName($form)
                ->firstOrFail());
        }

        return $instance;
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
        return $this->form->name;
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
        $this->form->name = $name;

        $this->form->save();

        return $this;
    }
}
