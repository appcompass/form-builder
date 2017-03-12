<?php

namespace P3in\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use P3in\Models\MenuItem;

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
        // Cleanup menu items that may target this page.
        MenuItem::where(['navigatable_id' => $model->id, 'navigatable_type' => get_class($model)])->forceDelete();
    }
}
