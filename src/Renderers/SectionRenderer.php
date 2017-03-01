<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Section;

class SectionRenderer
{
    private $section;
    private $build;

    public function __construct(Section $section)
    {
        $this->section = $section;

        return $this;
    }
}
