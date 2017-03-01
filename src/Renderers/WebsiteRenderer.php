<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Website;

class WebsiteRenderer
{
    private $website;
    private $build;

    public function __construct(Website $website)
    {
        $this->website = $website;

        return $this;
    }
}
