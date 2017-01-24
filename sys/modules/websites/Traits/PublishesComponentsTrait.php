<?php

namespace P3in\Traits;

use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Illuminate\Support\Facades\App;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

trait PublishesComponentsTrait
{
    public function getMountManager()
    {
        // prob should get the plus3website component publish module directory here.
        $dest = App::make('path.components') ? App::make('path.components') : public_path();

        // mostly for formatting.
        $siteDir = studly_case(str_slug(str_replace('.', ' ', $this->website->host)));

        $dest = realpath($dest).'/'.$siteDir;

        return new MountManager([
            'dest' => new Flysystem(new LocalAdapter($dest)),
        ]);
    }
}
