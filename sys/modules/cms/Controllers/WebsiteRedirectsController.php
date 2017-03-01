<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteRedirectsRepositoryInterface;

class WebsiteRedirectsController extends AbstractChildController
{
    public function __construct(WebsiteRedirectsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
