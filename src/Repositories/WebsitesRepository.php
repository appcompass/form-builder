<?php

namespace P3in\Repositories;

use P3in\Interfaces\WebsitesRepositoryInterface;
use P3in\Models\Website;

class WebsitesRepository extends AbstractRepository implements WebsitesRepositoryInterface
{
    protected $view_types = ['Table', 'Card'];

    public function __construct(Website $model)
    {
        $this->model = $model;
        // exclude the admin cp from the managed website list.
        $this->builder = $model->newQuery()->managed();
    }
}
