<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GalleryItemObserver
{
    public function creating(Model $model)
    {
        $model->type = $model->getType();
    }
}
