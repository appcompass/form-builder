<?php

namespace P3in\Repositories;

use P3in\Models\User;
use P3in\Interfaces\UsersRepositoryInterface;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}