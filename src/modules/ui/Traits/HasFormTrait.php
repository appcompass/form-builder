<?php

namespace P3in\Traits;

use P3in\Models\Form;

trait HasFormTrait
{
    // keep it simple for now, instead of using an interface
    // we're simply using the RouteMeta model directly.
    public function getForm($key)
    {
        $rslt = Form::byName($key)->firstOrFail();

        $rtn = $rslt->build();

        return $rtn;
    }

    public function setForm($array)
    {

    }
}
