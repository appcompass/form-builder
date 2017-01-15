<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleriesRepositoryInterface;

class GalleriesController extends AbstractController
{
    public function __construct(GalleriesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
