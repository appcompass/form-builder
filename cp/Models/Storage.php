<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use P3in\Models\Form;

// @TODO: prob needs a better name, CmsStorage or something.
class Storage extends Model
{
    protected $fillable = [
        'name',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    // @TODO: this is the wrong place for this.  we need a form per TYPE not per disk instance.
    public function type()
    {
        return $this->belongsTo(StorageType::class);
    }

    public function getDisk()
    {
        // @TODO: we do this because it seems to be the cleanest way to set the
        // disk instance config that's handled mostly internally.  the TODO is to
        // look into if there is a better way of doing this or not.
        Config::set('filesystems.disks.'.$this->name, $this->config);

        return LaravelStorage::disk($this->name);
    }

}
