<?php

namespace P3in\Builders;

use Closure;
use P3in\Builders\FormBuilder;
use P3in\Models\Form;
use P3in\Models\Layout;
use P3in\Models\Section;
use \Exception;

class SectionBuilder
{

    /**
     * Section instance
     */
    private $form;
    private $section;

    private function __construct(Form $form = null)
    {
        if (!is_null($form)) {
            if (!$form->formable instanceof Section) {
                throw new Exception('This form doesn\'t belong to a section');
            }

            $this->form = $form;
        }

        return $this;
    }

    /**
     * new
     *
     * @param      Website  $section   The Website
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public static function new(Layout $layout, $name, $template, Closure $closure = null)
    {
        $instance = new static();

        $section_name = camel_case($layout->name.' '.$name);

        $instance->section = new Section([
            'name' => $section_name,
            'template' => $template,
        ]);

        $instance->section->layout()->associate($layout);

        $instance->section->save();

        Form::where('name', $section_name)->delete(); //This prob shouldn't be here, but it is to reloading faster.

        $form = Form::create([
            'name' => $section_name
        ]);

        $form->formable()->associate($instance->section);
        $form->save();

        $formBuilder = new FormBuilder($form);

        if ($closure) {
            $closure($formBuilder);
        }

        return $instance;
    }

    // /**
    //  * edit
    //  *
    //  * @param      <type>       $section  The Section being edited
    //  *
    //  * @throws     \Exception   Section must be set
    //  *
    //  * @return     SectionBuilder  SectionBuilder instance
    //  */
    // public static function edit($section)
    // {
    //     if (!$section instanceof Section && !is_int($section)) {

    //         throw new Exception('Must pass id or Section instance');

    //     }

    //     if (is_int($section)) {

    //         $section = Section::findOrFail($section);

    //     }
    //     $instance = new static();

    //     return new static($section->form);
    // }

    public function getSection()
    {
        return $this->section;
    }
}
