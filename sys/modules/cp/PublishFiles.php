<?php

namespace P3in;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\App;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

class PublishFiles
{
    protected $mounts = [];
    protected $manager;

    public function __construct($key, $path)
    {
        if ($key && $path) {
            $this->setMount($key, $path);
        }
    }

    public function setMount(string $key, string $path)
    {
        $this->mounts[$key] = new Flysystem(new LocalAdapter($path));

        $this->manager = new MountManager($this->mounts);

        return $this;
    }

    /**
     * Gets a mount manager instance
     *
     * @return     MountManager  The mount manager.
     *
     */
    public function getMountManager()
    {
        return $this->manager;
    }

    public function verifyMount($name, $throw = true)
    {
        $check = isset($this->mounts[$name]);
        if (!$check && $throw) {
            throw new Exception('There is no mount defined by the name of '.$name.'.');
        }

        return $check;
    }

    public function getFile($from, $fileName)
    {
        $this->verifyMount($from);

        return $this->manager->read($from.'://' . $fileName);
    }

    public function publishFile(FilesystemAdapter $disk, $fileName, $data, $overwrite = false)
    {

        if ($overwrite) {
            $disk->put($fileName, $data);
        } else {
            if (!$disk->exists($fileName)) {
                $disk->put($fileName, $data);
            }
        }
    }

    public function listContents($from, $path = '')
    {
        return $this->manager->listContents($from.'://'.$path, true);
    }

    public function publishFolder($from, FilesystemAdapter $disk, $overwrite = false)
    {
        foreach ($this->listContents($from) as $file) {
            if ($file['type'] === 'file') {
                $path = $file['path'];
                $data = $this->getFile($from, $path);

                $this->publishFile($disk, $path, $data, $overwrite);
            }
        }
    }

    public function getPath($mount)
    {
        $this->verifyMount($mount);

        return $this->mounts[$mount]->getAdapter()->getPathPrefix();
    }
}
