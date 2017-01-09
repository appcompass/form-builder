<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PageContentsRepositoryInterface;

class PageContentsController extends AbstractChildController
{

    public function __construct(PageContentsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}