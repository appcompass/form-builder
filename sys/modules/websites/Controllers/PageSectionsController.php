<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PageSectionsRepositoryInterface;

class PageSectionsController extends AbstractChildController
{
    public function __construct(PageSectionsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
