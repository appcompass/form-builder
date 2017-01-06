<?php

namespace P3in\Controllers;

use P3in\Interfaces\WebsiteMenusRepositoryInterface;

class WebsiteMenusController extends AbstractChildController
{

    public function __construct(WebsiteMenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}