<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;

class GalleryPhotosController extends AbstractChildController
{
    public function __construct(GalleryPhotosRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
