<?php

namespace P3in\Repositories;

use P3in\Interfaces\PageSectionsRepositoryInterface;
use P3in\Models\Page;
use P3in\Models\Section;

class PageSectionsRepository extends AbstractChildRepository implements PageSectionsRepositoryInterface
{
    public function __construct(Section $model, Page $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'pages';
    }
}
