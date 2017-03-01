<?php

namespace P3in\Traits;

use P3in\Models\Form;

trait HasGateCheckTrait
{
    /**
     *  Gate Check
     */
    public function gateCheck($type, $model)
    {
        if (\Gate::denies($type, $model)) {
            abort(403);
        }
    }
}
