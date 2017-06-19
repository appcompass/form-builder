<?php

namespace P3in\Repositories;

use P3in\Repositories\AbstractRepository;
use P3in\Interfaces\WebsiteSetupRepositoryInterface;
use P3in\Models\Website;

class WebsiteSetupRepository extends AbstractRepository implements WebsiteSetupRepositoryInterface
{
    protected $view_types = ['Table', 'Card'];

    public function __construct(Website $parent)
    {
        $this->parent = $parent;
    }
}
