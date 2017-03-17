<?php

namespace P3in\Models;

use P3in\Requests\FormRequest;
use P3in\Models\Form; // in case we move this

class FormButler
{
    public static function get($form_name)
    {
        return (new static)->resolveFormFromString($form_name)->render();
    }

    private function parseRequest(FormRequest $request)
    {
        if ($request->has('form')) {

            return $this->resolveFormFromString($request->form)->render();

        }

        return;
    }

    private function resolveFormFromString($form_name)
    {
        return Form::whereName($form_name)->firstOrFail();
    }

    public static function store($form_name, $content)
    {
        // @TODO vvvv not really: what we wanna do here is resolve the form, get the linked Model
        // and fill it up
        // avoid breaking things for now
        if (isset($content['id'])) {

            MenuItem::findOrFail($content['id'])->update($content);

        } else {

            $form = Form::whereName($form_name)->firstOrFail();

            $form->store($content);

        }

        return ['success' => ['Updated']];
    }
}
