<?php

namespace P3in\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Validation\Validator;
use P3in\Models\Form;
use Route;

class FormRequest extends BaseFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $form = Form::byResource(Route::current()->getName())->first();

        if ($form) {

            \Log::info($form->rules());

            return $form->rules();

        } else {

            \Log::info('No validation found for resource ' . Route::current()->getName());

            return [];

        }

    }

    public function withValidator(Validator $validator)
    {
        // return $validator->errors();

        // dd($validator->fails());

        if ($validator->fails()) {

            return ['errors' => $validator->errors()->all()];

        }
    }

}