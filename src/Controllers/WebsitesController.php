<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsitesRepositoryInterface;

class WebsitesController extends AbstractController
{
    public function __construct(WebsitesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
