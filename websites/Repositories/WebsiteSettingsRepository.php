<?php

namespace P3in\Repositories;

use P3in\Interfaces\WebsiteSettingsRepositoryInterface;
use P3in\Models\Setting;
use P3in\Models\Website;

class WebsiteSettingsRepository extends AbstractChildRepository implements WebsiteSettingsRepositoryInterface
{
    public function __construct(Setting $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'settingsRel';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }
}
