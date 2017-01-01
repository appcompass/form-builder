<?php

namespace P3in\Controllers;

use P3in\Models\User;
use P3in\Interfaces\UsersRepositoryInterface;

class UsersController extends AbstractController
{

    public function __construct(UsersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}