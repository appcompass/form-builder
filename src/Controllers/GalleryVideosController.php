<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleryVideosRepositoryInterface;

class GalleryVideosController extends AbstractChildController
{
    public function __construct(GalleryVideosRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
