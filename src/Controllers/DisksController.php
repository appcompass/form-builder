<?php

namespace P3in\Controllers;

use P3in\Interfaces\DisksRepositoryInterface;

class DisksController extends AbstractController
{
    public function __construct(DisksRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
