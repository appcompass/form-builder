<?php

namespace P3in\Builders;

use Closure;
use Exception;
use P3in\Builders\PageLayoutBuilder;
use P3in\Models\Component;
use P3in\Models\Page;

class PageBuilder
{

    /**
     * Page instance
     */
    private $page;
    private $container;

    public function __construct(Page $page = null)
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
    public static function new($title, Website $website, Closure $closure = null)
    {
        $instance = new static();

        $instance->page = $website->pages()->create([

            'title' => $title,

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
     * @throws     Exception   Page must be set
     *
     * @return     PageBuilder  PageBuilder instance
     */
    public static function edit($page)
    {
        if (!$page instanceof Page && !is_int($page)) {
            throw new Exception('Must pass id or page instance');
        }

        if (is_int($page)) {
            $page = Page::findOrFail($page);
        }

        return new static($page);
    }


    public function addChild($title, $slug)
    {
        $page = $this->page->createChild([
            'title' => $title,
            'slug' => $slug,
        ]);

        return new static($page);
    }

    /**
     * Add a Container to a page and return it's PageComponentContent model instance
     * since we will probably want to add sections to the container.
     * @param int $columns
     * @param int $order
     * @return PageBuilder PageBuilder instance
     */
    public function addContainer($columns = 1, $order = 0)
    {
        return $this->page->addContainer($columns, $order);
    }

    /**
     * Add a section to a container.
     * @param Component $component
     * @param int $columns
     * @param int $order
     * @return PageBuilder PageBuilder instance
     */
    public function addSection(Component $component, int $columns, int $order)
    {
        if ($this->container) {
            $this->container->addSection($component, $columns, $order);
            return $this;
        } else {
            throw new Exception('a Container must be set to add Sections.');
        }
    }

    public function getPage()
    {
        return $this->page;
    }
}
