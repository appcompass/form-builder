<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Layout;

class LayoutRenderer
{
    private $layout;
    private $build;

    public function __construct(Layout $layout)
    {
        $this->layout = $layout;

        return $this;
    }
}
