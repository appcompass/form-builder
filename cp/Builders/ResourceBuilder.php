<?php

namespace P3in\Builders;

use Closure;
use P3in\Builders\FormBuilder;
use P3in\Models\Field;
use P3in\Models\Form;
use P3in\Models\Resource;

// @TODO this all goes

class ResourceBuilder {

	/**
	 * FormBuilder instance
	 */
	// private $formBuilder;

    /**
     *  Resource instance
     */
    // private $resource;


    // on construction we just set the resource name, constructor is private
	// private function __construct($resource_name, FormBuilder $formBuilder) {

 //        $this->resource = Resource::create([
 //            'resource' => $resource_name,
 //            'form_id' => $formBuilder->getForm()->id
 //        ]);

 //        $this->formBuilder = $formBuilder;

	// 	return $this;
	// }

	/**
	 * New a form
	 *
	 * @param      string  $name   Form Name
	 * @param      string  $resource The resource the form points to
	 * @param      Closure $closure called and receives the ResourceBuilder instance
	 *
	 * @return     FormBuilder Instance
	 */
	// public static function new($resource_name, Closure $closure = null)
    // {

        // resource_name => website.pages | user.permissions | users | websites | page.content

        // create a formbuilder instance, based on the root name of the resource it's gonna point at
 //        $formBuilder = FormBuilder::new ([

 //            'name' => $resource_name

 //        ]);

	// 	$instance = new static($resource, $formBuilder);

	// 	if ($closure) {

	// 		$closure($instance->formBuilder);

	// 	}

	// 	return $instance->formBuilder;
	// }

	/**
	 * Edit a form
	 *
	 * @param      string  $form   The form
	 *
	 * @return     static  ( description_of_the_return_value )
	 */
	// public static function edit($form) {
	// 	if ($form instanceof Form) {

	// 		$instance = new static($form);

	// 	} elseif (is_string($form)) {

	// 		$instance = new static(Form::whereName($form)
	// 				->firstOrFail());

	// 	}

	// 	return $instance;
	// }

	/**
	 * Gets the name.
	 *
	 * @param      <type>  $name   The name
	 *
	 * @return     <type>  The name.
	 */
	// public function getName($name = null) {
	// 	return $this->form->name;
	// }

	/**
	 * Sets the name.
	 *
	 * @param      <type>  $name   The name
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	// public function setName($name) {
	// 	$this->form->name = $name;

	// 	$this->form->save();

	// 	return $this;
	// }

	/**
	 * Gets the alias.
	 *
	 * @return     <type>  The alias.
	 */
	// public function getAlias() {
	// 	return $this->alias;
	// }

	/**
	 * Sets the alias.
	 *
	 * @param      <type>  $alias  The alias
	 */
	// public function setAlias($alias) {
	// 	return $this->form->setAlias($alias);
	// }

	/**
	 * Drops an Alias
	 *
	 * @param      <type>  $alias  The alias
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	// public function dropAlias($alias) {
	// 	$this->form->dropAlias($alias);

	// 	return $this;
	// }

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
	// public function drop($name, $type = null) {
	// 	$field = $this->form->fields->where('name', $name);

	// 	if (!count($field)) {
	// 		return $this;
	// 	}

	// 	if (count($field) > 1 and is_null($type)) {
	// 		throw new \Exception("Multiple <{$name}> found, please add type");
	// 	} elseif (count($field) > 1 and !is_null($type)) {
	// 		$field = $field->where('type', $type);

	// 		if (count($field) > 1) {
	// 			throw new \Exception("Sorry there doesn't seem to be an enough specific combination to get a single result. Halting.");
	// 		} else {
	// 			$field->first()->delete();

	// 			return $this;
	// 		}
	// 	} elseif (count($field) === 1) {
	// 		$field->first()->delete();
	// 	}
	// }
}
