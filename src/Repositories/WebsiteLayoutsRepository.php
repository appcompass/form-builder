<?php

namespace P3in\Repositories;

use P3in\Interfaces\WebsiteLayoutsRepositoryInterface;
use P3in\Models\Layout;
use P3in\Models\Website;

class WebsiteLayoutsRepository extends AbstractChildRepository implements WebsiteLayoutsRepositoryInterface
{
    public function __construct(Layout $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'layouts';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
