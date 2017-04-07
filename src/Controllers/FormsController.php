<?php

namespace P3in\Controllers;

use P3in\Interfaces\FormsRepositoryInterface;

class FormsController extends AbstractController
{
    public function __construct(FormsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
