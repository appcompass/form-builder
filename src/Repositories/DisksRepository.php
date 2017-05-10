<?php

namespace P3in\Repositories;

use P3in\Models\StorageConfig;
use P3in\Interfaces\DisksRepositoryInterface;

class DisksRepository extends AbstractRepository implements DisksRepositoryInterface
{
    protected $with = ['type'];

    public function __construct(StorageConfig $model)
    {
        $this->model = $model;
    }
}
