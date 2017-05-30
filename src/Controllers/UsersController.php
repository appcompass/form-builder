<?php

namespace P3in\Controllers;

use P3in\Interfaces\UsersRepositoryInterface;
use App\User;

class UsersController extends AbstractController
{
    public function __construct(UsersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
