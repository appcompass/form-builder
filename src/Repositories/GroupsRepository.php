<?php

namespace P3in\Repositories;

use P3in\Interfaces\GroupsRepositoryInterface;
use P3in\Models\Group;

class GroupsRepository extends AbstractRepository implements GroupsRepositoryInterface
{
    public $model;

    public function __construct(Group $model)
    {
        $this->model = $model;
    }
}
