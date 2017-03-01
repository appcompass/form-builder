<?php

namespace P3in\Controllers;

use P3in\Interfaces\GroupsRepositoryInterface;

class GroupsController extends AbstractController
{
    public function __construct(GroupsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
