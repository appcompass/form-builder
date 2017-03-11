<?php

namespace P3in\Repositories;

use P3in\Interfaces\ResourcesRepositoryInterface;
use P3in\Models\Resource;

class ResourcesRepository extends AbstractRepository implements ResourcesRepositoryInterface
{
    public $model;

    public function __construct(Resource $model)
    {
        $this->model = $model;
    }
}
