<?php

namespace P3in\Controllers;

use P3in\Interfaces\UserGroupsRepositoryInterface;

class UserGroupsController extends AbstractChildController
{

    public function __construct(UserGroupsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}