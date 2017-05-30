<?php

namespace P3in\Repositories;

use App\User;
use P3in\Models\Permission;
use P3in\Interfaces\PermissionsRepositoryInterface;

class PermissionsRepository extends AbstractRepository implements PermissionsRepositoryInterface
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
}
