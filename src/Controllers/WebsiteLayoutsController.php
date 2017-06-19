<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteLayoutsRepositoryInterface;

class WebsiteLayoutsController extends AbstractChildController
{
    public function __construct(WebsiteLayoutsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
