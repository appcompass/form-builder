<?php

namespace P3in\Controllers;

use P3in\Interfaces\UserRolesRepositoryInterface;

class UserRolesController extends AbstractChildController
{
    public function __construct(UserRolesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
