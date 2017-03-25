<?php

namespace P3in\Repositories;

use P3in\Models\Page;
use P3in\Models\Website;
use P3in\Interfaces\WebsitePagesRepositoryInterface;

class WebsitePagesRepository extends AbstractChildRepository implements WebsitePagesRepositoryInterface
{
    protected $view_types = ['Table', 'Card'];

    public function __construct(Page $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'pages';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
