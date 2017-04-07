<?php

namespace P3in\Controllers;

use P3in\Interfaces\RolePermissionsRepositoryInterface;

class RolePermissionsController extends AbstractChildController
{
    public function __construct(RolePermissionsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
