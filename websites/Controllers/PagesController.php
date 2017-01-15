<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PagesRepositoryInterface;

class PagesController extends AbstractController
{
    public function __construct(PagesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
}
