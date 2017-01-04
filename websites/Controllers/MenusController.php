<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\MenusRepositoryInterface;

class MenusController extends AbstractController
{

    public function __construct(MenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}