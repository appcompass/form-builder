<?php

namespace P3in\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use P3in\Models\Storage;

trait HasStorage
{

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

}