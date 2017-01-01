<?php

namespace P3in\Repositories;

use P3in\Interfaces\PagesRepositoryInterface;
use P3in\Models\Page;

class PagesRepository extends AbstractRepository implements PagesRepositoryInterface
{

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

}