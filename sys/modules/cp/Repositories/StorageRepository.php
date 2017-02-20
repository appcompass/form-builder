<?php

namespace P3in\Repositories;

use P3in\Models\Storage;
use P3in\Interfaces\StorageRepositoryInterface;

class UsersRepository extends AbstractRepository implements StorageRepositoryInterface
{
    public function __construct(Storage $model)
    {
        $this->model = $model;
    }
}