<?php

namespace P3in\Traits;

use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Illuminate\Support\Facades\App;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

trait PublishesComponentsTrait
{
    /**
     * Gets a mount manager instance
     *
     * @return     MountManager  The mount manager.
     *
     */
    // @TODO this is way too specific for a Trait
    public function getMountManager($folder = '')
    {
        // prob should get the plus3website component publish module directory here.
        $dest = App::make('path.components') ? App::make('path.components') : public_path();

        // mostly for formatting.
        $siteDir = studly_case(str_slug(str_replace('.', ' ', $this->website->host)));

        $dest = realpath($dest).'/'.$siteDir.'/'.$folder;

        return new MountManager([
            'dest' => new Flysystem(new LocalAdapter($dest)),
        ]);
    }
}
