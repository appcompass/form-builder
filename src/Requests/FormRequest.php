<?php

namespace P3in\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use \Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use P3in\Models\Form;
use Route;

class FormRequest extends BaseFormRequest
{


    public function authorize()
    {
        return true;
    }

    /**
     * Fetch form rules based on resource name
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     array                     ( description_of_the_return_value )
     */
    public function rules(Request $request)
    {
        $form = Form::byResource(Route::current()->getName())->first();

        if (count($request->allFiles())) {

            // @TODO this would be the ideal spot to
            //   - upload a file
            //   - append file path to the request

        }

        if ($form && in_array($request->getMethod(), ['POST', 'PUT'])) {

            return $form->rules();

        } else {

            return [];

        }

    }

}