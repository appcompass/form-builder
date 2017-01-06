<?php

namespace P3in\Models;

use P3in\Models\Page;
use P3in\Models\Layout;
use P3in\Models\Section;
use P3in\Models\PageSection;
use Closure;

class PageBuilder
{

    /**
     * Page instance
     */
    private $page;

    private function __construct(Page $page = null)
    {
        if (!is_null($page)) {

            $this->page = $page;

        }

        return $this;
    }

    /**
     * new
     *
     * @param      Page  $page   The Page
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public static function new($name, Website $website, Closure $closure = null)
    {

        $instance = new static();

        $instance->page = $website->pages()->create([

            'name' => $name,

        ]);

        if ($closure) {

            $closure($instance);

        }

        return $instance;
    }

    /**
     * edit
     *
     * @param      <type>       $page  The page being edited
     *
     * @throws     \Exception   Page must be set
     *
     * @return     PageBuilder  PageBuilder instance
     */
    public static function edit($page)
    {
        if (!$page instanceof Page && !is_int($page)) {

            throw new \Exception('Must pass id or page instance');

        }

        if (is_int($page)) {

            $page = Page::findOrFail($page);

        }

        return new static($page);
    }

    /**
     * add factory
     *
     * @param      $item        Mixed
     *
     * @throws     \Exception   (description)
     *
     * @return     PageSection      PageSection instance
     */
    public function add($item)
    {

        if (!$this->page) {

            throw new \Exception('Page not selected.');

        }

        if ($item instanceof PageSection) {

            $page_section = $item;

        } else if (is_array($item)) {

            $page_section = new PageSection($item);

        } else {

            throw new \Exception("Trying to add something i don't understand");

        }

        if ($this->page->add($page_section)) {

            return $page_section;

        } else {

            throw new \Exception("Something went wrong while adding the PageSection {$page_section->id} to Page {$this->page->id}");

        }
    }

    /**
     * Drop PageSection
     *
     * @param      \App\PageSection  $page_section  The navigation item
     */
    public function drop($item)
    {
        if (is_int($item)) {

            $page_section = $this->page->sections()->findOrFail($item);

        } else if ($item instanceof PageSection) {

            $page_section = $this->page->sections()->findOrFail($item->id);

        }

        if ($page_section->delete()) {

            return true;

        } else {

            throw new \Exception("Errors while removing PageSection");

        }

    }

}