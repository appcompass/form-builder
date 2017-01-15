<?php

namespace P3in\Repositories;

use P3in\Interfaces\WebsiteRedirectsRepositoryInterface;
use P3in\Models\Redirect;
use P3in\Models\Website;

class WebsiteRedirectsRepository extends AbstractChildRepository implements WebsiteRedirectsRepositoryInterface
{
    public function __construct(Redirect $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'redirects';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
