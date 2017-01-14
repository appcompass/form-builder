<?php

namespace P3in\Builders;

use Closure;
use P3in\Models\Field;
use P3in\Models\Form;

class FormBuilder
{

    /**
     * Form instance
     */
    public $field;

    public function __construct(Field $field = null)
    {
        if (!is_null($field)) {

            $this->field = $field;

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
     * @return     static  ( description_of_the_return_value )
     */
    public static function new($name, Model $parent, Closure $closure = null)
    {
        $instance = new static();

        $instance->form = $parent->fields()->create(['name' => $name]);

        if ($closure) {

            $closure($instance);

        }

        return $instance;
    }

    /**
     * Edit a form
     *
     * @param      string  $field   The form
     *
     * @return     static  ( description_of_the_return_value )
     */
    public static function edit($field)
    {
        if ($field instanceof Form) {

            $instance = new static($field);

        } else if (is_string($field)) {

            $instance = new static(Form::whereName($field)
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

    /**
     * Gets the alias.
     *
     * @return     <type>  The alias.
     */
    // public function getAlias()
    // {
    //     return $this->alias;
    // }

    /**
     * Sets the alias.
     *
     * @param      <type>  $alias  The alias
     */
    // public function setAlias($alias)
    // {
    //     return $this->field->setAlias($alias);
    // }

    /**
     * Drops an Alias
     *
     * @param      <type>  $alias  The alias
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    // public function dropAlias($alias)
    // {
    //     $this->field->dropAlias($alias);

    //     return $this;
    // }

    /**
     * Sets the layout for list view.
     *
     * @param      <type>  $list_type  The list type
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    // public function setListLayout($list_type)
    // {
    //     return $this->field->setListLayout($list_type);
    // }

    /**
     * Gets the fields.
     *
     * @return     <type>  The fields.
     */
    public function getFields()
    {
        return $this->field->fields;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $label       The label
     * @param      <type>  $name        The name
     * @param      string  $validation  The validation
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function string($label, $name = null, $validation = [])
    {
        return $this->addField($label, $name, 'string', $validation);
    }

    public function text($label, $name = null, $validation = [])
    {
        return $this->addField($label, $name, 'text', $validation);
    }

    public function boolean($label, $name = null, $validation = [])
    {
        return $this->addField($label, $name, 'boolean', $validation);
    }

    public function secret($label = 'Password', $name = 'password', $validation = [])
    {
        return $this->addField($label, $name, 'secret', $validation);
    }

    public function menuEditor($label = 'Menu Editor', $name = 'menu-editor', $validation = [])
    {
        return $this->addField($label, $name, 'menueditor', $validation);
    }

    public function repeatable($label, $name = null, $validation = [], Closure $closure = null)
    {
        return $this->addField($label, $name, 'repeatable', $validation, $closure);
    }

                // $fieldBuilder->repeatable('Slides', 'slides', function($slide){ // the name on all repeatables automatically prepend the parent section's name.
                //     $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                //     $slide->text('Title', 'title', ['required']);
                //     $slide->wysiwyg('Description', 'description', ['required']);
                //     $slide->text('Link Text', 'link_text', ['required']);
                //     $slide->href('Link Destination', 'link_href', ['required']);
                // });

    /**
     * Adds a field.
     *
     * @param      <type>  $label       The label
     * @param      <type>  $name        The name
     * @param      string  $type        The type
     * @param      string  $validation  The validation
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    private function addField($label, $name = null, $type = 'string', $validation = [], Closure $closure = null)
    {
        if (is_null($name)) {
            $name = str_replace(' ', '_', strtolower($label));
        }

        $field = Field::create([
            'label' => $label,
            'name' => $name,
            'type' => $type
            // 'validation' => ''
        ]);

        $this->field->fields()->attach($field);

        if ($closure) {

            $closure($field);

        }

        return $field;
    }

    /**
     * drops a field by name or name/type
     *
     * @param      <string>      $name   The name
     * @param      <string>      $type   The type
     *
     * @throws     \Exception    (in case no single combination is found)
     *
     * @return     self          ( self on success/no match )
     */
    public function drop($name, $type = null)
    {
        $field = $this->field->fields->where('name', $name);

        if (! count($field)) {

            return $this;

        }

        if (count($field) > 1 AND is_null($type)) {

            throw new \Exception("Multiple <{$name}> found, please add type");

        } else if (count($field) > 1 AND ! is_null($type)) {

            $field = $field->where('type', $type);


            if (count($field) > 1) {

                throw new \Exception("Sorry there doesn't seem to be an enough specific combination to get a single result. Halting.");

            } else {

                $field->first()->delete();

                return $this;

            }
        } else if (count($field) === 1) {

            $field->first()->delete();

        }
    }

}
