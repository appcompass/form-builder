<?php

namespace P3in\Repositories;

use P3in\Interfaces\PageContentsRepositoryInterface;
use P3in\Models\Page;
use P3in\Models\PageContent;

class PageContentsRepository extends AbstractChildRepository implements PageContentsRepositoryInterface
{
    public function __construct(PageContent $model, Page $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'contents';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
