<?php

namespace P3in\Traits;

use P3in\Models\Storage;


trait StoresFiles
{
    public function initStorage(array $disks)
    {
        $storages = Storage::whereIn('name', $disks)->get();
        // stores the config in memory.
        $storages->each(function($storage){
            $storage->setConfig();
        });
    }
}
