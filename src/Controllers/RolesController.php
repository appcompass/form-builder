<?php

namespace P3in\Controllers;

use P3in\Interfaces\RolesRepositoryInterface;

class RolesController extends AbstractController
{
    public function __construct(RolesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
