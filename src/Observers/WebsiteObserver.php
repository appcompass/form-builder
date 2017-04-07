<?php

namespace P3in\Observers;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Gallery;

class WebsiteObserver
{
    public function saving(Model $model)
    {
    }

    public function saved(Model $model)
    {
    }

    public function deleting(Model $model)
    {
    }

    public function deleted(Model $model)
    {
        Gallery::where(['galleryable_id' => $model->id, 'galleryable_type' => get_class($model)])->delete();
    }
}
