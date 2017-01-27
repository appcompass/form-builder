<?php

namespace P3in;

use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Illuminate\Support\Facades\App;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;
use Exception;

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

    public function publishFile($to, $fileName, $data, $overwrite = false)
    {
        $this->verifyMount($to);

        if ($overwrite) {

            $this->manager->put($to.'://' . $fileName, $data);

        } else {

            if (!$this->manager->has($to.'://' . $fileName)) {

                $this->manager->put($to.'://' . $fileName, $data);

            }

        }

    }

    public function publishFolder($from, $to, $overwrite = false)
    {
        foreach ($this->manager->listContents($from.'://', true) as $file) {

            if ($file['type'] === 'file') {
                $path = $file['path'];
                $data = $this->getFile($from, $path);

                $this->publishFile($to, $path, $data, $overwrite);

            }

        }
    }

    public function getPath($mount)
    {
        $this->verifyMount($mount);

        return $this->mounts[$mount]->getAdapter()->getPathPrefix();
    }
}
