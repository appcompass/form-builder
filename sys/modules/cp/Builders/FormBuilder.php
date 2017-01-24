<?php

namespace P3in\Builders;

use Closure;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Field;
use P3in\Models\Form;
use P3in\Models\Resource;
use P3in\Models\Types\BaseField;

class FormBuilder
{

    /**
     * Form instance
     */
    public $form;

    private function __construct(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    public static function new($name, Closure $closure = null)
    {
        $form = Form::firstOrCreate([
            'name' => $name,
        ]);

        $instance = new static($form);

        if ($closure) {
            $closure($instance);
        }

        return $instance;
    }

    /**
     * Edit a form
     *
     * @param      string  $form   The form
     *
     * @return     static  ( description_of_the_return_value )
     */
    public static function edit($form): FormBuilder
    {
        if ($form instanceof Form) {

            $instance = new static($form);

        } elseif (is_string($form)) {

            $instance = new static(Form::whereName($form)->firstOrFail());

        }

        return $instance;
    }

    /**
     * Gets the form.
     *
     * @return     <type>  The form.
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Sets the owner.
     *
     * @param      Model  $owner  The owner
     */
    public function setOwner(Model $owner)
    {
        $this->form->setOwner($owner);
    }

    /**
     * Links to resources.
     *
     * @param      Mixed  $resources  The resources you're linking the form to
     */
    public function linkToResources($resources)
    {
        foreach ((array) $resources as $resource) {
            Resource::create([
                'resource' => $resource,
                'form_id' => $this->form->id
            ]);
        }
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

    /**
     * Sets the field parent.
     *
     * @param      <type>  $parent  The parent
     */
    public function setFieldParent($parent)
    {
        $this->fields_parent = $parent;
    }

    /**
     * Sets the list layout.
     *
     * @param      <type>  $list_layout  The list layout
     *
     * @return     FormBuilder instance
     */
    public function setListLayout($list_layout)
    {
        $this->form->setListLayout($list_layout);

        return $this;
    }

    public function __call($method, array $args)
    {
        // we'll try to new ucfirst that class, if that works we got it already
        $field_name = ucfirst($method) . 'Type';

        // full class name
        $class_name = '\P3in\Models\Types\\' . $field_name;

        if (!class_exists($class_name)) {
            die("The FieldType: <$field_name> does not exist. Do Something!");
        }

        return $this->addField($class_name::make($args[0], $args[1]));
    }

    /**
     * Adds a field.
     *
     */
    private function addField(BaseField $field_type)
    {
        $this->form->fields()->attach($field_type->field);

        return $field_type->field;
    }

    /**
     * Gets the fields.
     *
     * @return     <type>  The fields.
     */
    public function getFields()
    {
        return $this->fields_parent->fields;
    }

    /**
     * drops a field by name or name/type
     *
     * @param      <string>      $name   The name
     * @param      <string>      $type   The type
     *
     * @throws     Exception    (in case no single combination is found)
     *
     * @return     self          ( self on success/no match )
     */
    public function drop($name, $type = null)
    {
        $field = $this->fields_parent->fields->where('name', $name);

        if (!count($field)) {
            return $this;
        }

        if (count($field) > 1 and is_null($type)) {
            throw new Exception("Multiple <{$name}> found, please add type");
        } elseif (count($field) > 1 and !is_null($type)) {
            $field = $field->where('type', $type);

            if (count($field) > 1) {
                throw new Exception("Sorry there doesn't seem to be an enough specific combination to get a single result. Halting.");
            } else {
                $field->first()->delete();

                return $this;
            }
        } elseif (count($field) === 1) {
            $field->first()->delete();
        }
    }
}
