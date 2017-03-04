<?php

namespace P3in\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PageObserver
{
    public function saving(Model $model)
    {
        // @NOTE url is protected (and it has to be) so it doesn't allow us to edit it here
        // $model->url = $model->buildUrl();
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
