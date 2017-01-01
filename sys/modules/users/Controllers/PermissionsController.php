<?php

namespace P3in\Controllers;

use P3in\Interfaces\PermissionsRepositoryInterface;

class PermissionsController extends AbstractController
{

    public function __construct(PermissionsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}