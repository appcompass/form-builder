<?php

namespace P3in\Repositories;

use P3in\Repositories\AbstractChildRepository;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\Menu;
use P3in\Models\Website;

class WebsiteMenusRepository extends AbstractChildRepository implements WebsiteMenusRepositoryInterface
{
    public function __construct(Menu $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'menus';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
