<?php

namespace P3in\Models;

use Illuminate\Http\Request;
use P3in\Models\Form; // in case we move this

class FormButler
{

    public static function get(Request $request, $form_name)
    {
        return (new static)->resolveFormFromString($form_name);
    }

    private function parseRequest(Request $request)
    {
        if ($request->has('form')) {

            return $this->resolveFormFromString($request->form);

        }

        return;
    }

    private function resolveFormFromString($form_name)
    {
        return Form::whereName($form_name)->firstOrFail()->fields;
    }

    public static function store($form_name, $content)
    {
        // validate form

        // in this case we're storing related content, should become an obeserver
        // store form
        switch ($content['type']) {
            case 'Link':
                // dd(MenuItem::findOrFail($content['id'])->navigatable);
                MenuItem::findOrFail($content['id'])->navigatable->update($content);
                break;
            case 'Page':
                MenuItem::findOrFail($content['id'])->update($content);
                break;
        }

    }
}