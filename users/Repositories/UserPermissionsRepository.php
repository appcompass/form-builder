<?php

namespace P3in\Repositories;

use P3in\Models\User;
use P3in\Models\Permission;
use P3in\Interfaces\UserPermissionsRepositoryInterface;

class UserPermissionsRepository extends AbstractChildRepository implements UserPermissionsRepositoryInterface
{

    protected $view = 'MultiSelect';

    public function __construct(Permission $model, User $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        // in this case (BelongsToMany relation) we want the dependent class to reference the "parent"
        // relation child -> parent
        $this->relationName = 'users';

        // relation from parent to child
        $this->parentToChild = 'permissions';
    }
}
