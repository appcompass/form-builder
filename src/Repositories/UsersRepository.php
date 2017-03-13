<?php

namespace P3in\Repositories;

use P3in\Models\User;
use P3in\Interfaces\UsersRepositoryInterface;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface
{
    const EDIT_OWNED = 1;

    protected $owned_key = 'id';

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
