<?php

namespace P3in\Builders;

use P3in\Models\Page;
use P3in\Models\Layout;
use P3in\Models\Section;
use P3in\Models\PageContent;
use Closure;
use Exception;

class PageLayoutBuilder
{

    /**
     * Page instance
     */
    private $page;
    private $layout;

    public function __construct(Page &$page, Layout $layout, $order = 1)
    {
        $page->layouts()->attach($layout, ['order' => $order]);

        $this->page = $page;
        $this->layout = $layout;

        return $this;
    }

    public function addSection(SectionBuilder $builder, $order = 1)
    {
        if ($builder instanceof SectionBuilder) {
            $section = $builder->getSection();
            if (!$this->layout->is($section->layout)) {
                throw new Exception("This page must have a layout assigned to it before adding a section.");
            }

            $this->page->sections()->attach($section, ['order' => $order]);
        } else {
            throw new Exception("Trying to add something i don't understand.");
        }

        return $this;
    }

    public function addSections(array $sections)
    {
        foreach ($sections as $i => $section) {
            $this->addSection($section, $i+1);
        }

        return $this;
    }
}
