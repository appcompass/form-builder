<?php

namespace P3in\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PageObserver
{
    public function saving(Model $model)
    {
        $model->url = $model->buildUrl();
    }

    public function saved(Model $model)
    {
        $model->updateChildrenUrl();
    }

    public function deleting(Model $model)
    {
    }

    public function deleted(Model $model)
    {

    }
}
