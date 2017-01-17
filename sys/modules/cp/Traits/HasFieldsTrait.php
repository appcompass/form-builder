<?php

namespace P3in\Traits;

trait HasFieldsTrait {
	// public function setFieldParent($parent)
	// {
	//     $this->fields_parent = $parent;
	// }
	// /**
	//  * Gets the fields.
	//  *
	//  * @return     <type>  The fields.
	//  */
	// public function getFields()
	// {
	//     return $this->fields_parent->fields;
	// }

	// /**
	//  * { function_description }
	//  *
	//  * @param      <type>  $label       The label
	//  * @param      <type>  $name        The name
	//  * @param      string  $validation  The validation
	//  *
	//  * @return     <type>  ( description_of_the_return_value )
	//  */
	// public function string($label, $name = null, $validation = [])
	// {
	//     return $this->addField($label, $name, 'string', $validation);
	// }

	// public function text($label, $name = null, $validation = [])
	// {
	//     return $this->addField($label, $name, 'text', $validation);
	// }

	// public function radio($label, $name = null, $options = [])
	// {
	//     return $this->addField($label, $name, 'radio', $options); // this is just stubbed.
	// }
	// public function boolean($label, $name = null, $validation = [])
	// {
	//     return $this->addField($label, $name, 'boolean', $validation);
	// }

	// public function secret($label = 'Password', $name = 'password', $validation = [])
	// {
	//     return $this->addField($label, $name, 'secret', $validation);
	// }

	// public function menuEditor($label = 'Menu Editor', $name = 'menu-editor', $validation = [])
	// {
	//     return $this->addField($label, $name, 'menueditor', $validation);
	// }

	// public function formBuilder($label, $name = null, $options = [])
	// {
	//     return $this->addField($label, $name, 'formbuilder', $options);
	// }

	// public function loginForm($label, $name = null, $options = [])
	// {
	//     return $this->addField($label, $name, 'loginform', $options);
	// }

	// public function map($label = 'Map', $name = null, $options = [])
	// {
	//     return $this->addField($label, $name, 'map', $options);
	// }

	// public function wysiwyg($label, $name = null, $validation = [])
	// {
	//     return $this->addField($label, $name, 'wysiwyg', $validation);
	// }

	// public function link($label, $name = null, $validation = [])
	// {
	//     return $this->addField($label, $name, 'link', $validation);
	// }

	// public function file($label, $name = null, $modelName, $validation = [])
	// {
	//     // something wih the $modelName
	//     return $this->addField($label, $name, 'file', $validation);
	// }

	// public function pageSectionSelect($label, $name = null, $validation = [])
	// {
	//     // Page select (dropdown)
	//     // Page sections (checkboxes) (only available after page selection)
	//     return $this->addField($label, $name, 'pagesectionselect', $validation);
	// }
	// public function fieldset($label, $name = null, $validation = [], Closure $closure = null)
	// {
	//     return $this->addField($label, $name, 'fieldset', $validation, $closure);
	// }

	// /**
	//  * Adds a field.
	//  *
	//  * @param      <type>  $label       The label
	//  * @param      <type>  $name        The name
	//  * @param      string  $type        The type
	//  * @param      string  $validation  The validation
	//  *
	//  * @return     <type>  ( description_of_the_return_value )
	//  */
	// private function addField($label, $name = null, $type = 'string', $validation = [], Closure $closure = null)
	// {
	//     if (is_null($name)) {
	//         $name = str_replace(' ', '_', strtolower($label));
	//     }

	//     $field = Field::create([
	//         'label' => $label,
	//         'name' => $name,
	//         'type' => $type
	//         // 'validation' => ''
	//     ]);

	//     $rel = $this->fields_parent->fields();

	//     if ($rel instanceof BelongsToMany) {
	//         $rel->attach($field);
	//     } elseif ($rel instanceof HasMany) {
	//         $rel->save($field);
	//     }

	//     if ($closure) {
	//         $fieldBuilder = new FieldBuilder($field);
	//         $closure($fieldBuilder);
	//     }

	//     return $field;
	// }

	// /**
	//  * drops a field by name or name/type
	//  *
	//  * @param      <string>      $name   The name
	//  * @param      <string>      $type   The type
	//  *
	//  * @throws     Exception    (in case no single combination is found)
	//  *
	//  * @return     self          ( self on success/no match )
	//  */
	// public function drop($name, $type = null)
	// {
	//     $field = $this->fields_parent->fields->where('name', $name);

	//     if (! count($field)) {
	//         return $this;
	//     }

	//     if (count($field) > 1 and is_null($type)) {
	//         throw new Exception("Multiple <{$name}> found, please add type");
	//     } elseif (count($field) > 1 and ! is_null($type)) {
	//         $field = $field->where('type', $type);

	//         if (count($field) > 1) {
	//             throw new Exception("Sorry there doesn't seem to be an enough specific combination to get a single result. Halting.");
	//         } else {
	//             $field->first()->delete();

	//             return $this;
	//         }
	//     } elseif (count($field) === 1) {
	//         $field->first()->delete();
	//     }
	// }
}
