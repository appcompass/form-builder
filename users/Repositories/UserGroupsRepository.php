<?php

namespace P3in\Repositories;

use P3in\Models\User;
use P3in\Models\Group;
use P3in\Interfaces\UserGroupsRepositoryInterface;

class UserGroupsRepository extends AbstractChildRepository implements UserGroupsRepositoryInterface {

    public function __construct(Group $model, User $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'users';

        $this->parentToChild = 'groups';
    }

}