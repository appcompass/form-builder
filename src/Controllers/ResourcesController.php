<?php

namespace P3in\Controllers;

use P3in\Interfaces\ResourcesRepositoryInterface;

class ResourcesController extends AbstractController
{
    public function __construct(ResourcesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
