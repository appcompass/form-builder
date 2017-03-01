<?php

namespace P3in\Controllers;

use P3in\Interfaces\DisksRepositoryInterface;
use P3in\Models\Storage;

class DiskController extends AbstractController
{
    public function __construct(DisksRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}
