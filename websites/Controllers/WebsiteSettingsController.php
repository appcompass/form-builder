<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteSettingsRepositoryInterface;

class WebsiteSettingsController extends AbstractChildController
{

    public function __construct(WebsiteSettingsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

}