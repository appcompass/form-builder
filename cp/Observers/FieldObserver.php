<?php

namespace P3in\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FieldObserver
{
    public function creating(Model $model)
    {
        // Most fields are editable.
        $model->config = [
            'to_edit' => true
        ];
    }

}
