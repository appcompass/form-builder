<?php

namespace P3in\Repositories;

use P3in\Interfaces\WebsitesRepositoryInterface;
use P3in\Models\Website;

class WebsitesRepository extends AbstractRepository implements WebsitesRepositoryInterface
{
    public function __construct(Website $model)
    {
        $this->model = $model;
    }
}
