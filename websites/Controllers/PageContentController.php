<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PageContentRepositoryInterface;

class PageContentController extends AbstractChildController
{

    public function __construct(PageContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}