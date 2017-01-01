<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsitePagesRepositoryInterface;

class WebsitePagesController extends AbstractChildController
{

    public function __construct(WebsitePagesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}