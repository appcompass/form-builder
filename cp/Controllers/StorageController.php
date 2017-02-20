<?php

namespace P3in\Controllers;

use P3in\Models\User;
use P3in\Interfaces\StorageRepositoryInterface;

class StorageController extends AbstractController
{
    public function __construct(StorageRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}