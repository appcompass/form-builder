<?php

namespace P3in\Builders;

use P3in\Models\Page;
use P3in\Models\Layout;
use P3in\Models\Section;
use P3in\Models\PageContent;
use Closure;
use Exception;

class PageBuilder
{

    /**
     * Page instance
     */
    private $page;

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

    public function add($item, $order = 1)
    {
        if ($item instanceof Layout) {
            $this->page->layouts()->attach($item, ['order' => $order]);
        } else if ($item instanceof SectionBuilder) {
            $section = $item->getSection();
            if (!$this->page->layouts->contains($section->layout)) {
                throw new Exception("This page must have a layout assigned to it before adding a section.");
            }

            $this->page->sections()->attach($section, ['order' => $order]);

        } else {
            throw new Exception("Trying to add something i don't understand.");
        }
        return $this;
    }

    // /**
    //  * add factory
    //  *
    //  * @param      $item        Mixed
    //  *
    //  * @throws     Exception   (description)
    //  *
    //  * @return     PageContent      PageContent instance
    //  */
    // public function add($item)
    // {

    //     if (!$this->page) {

    //         throw new Exception('Page not selected.');

    //     }

    //     if ($item instanceof PageContent) {

    //         $page_section = $item;

    //     } else if (is_int($item)) {

    //         $page_section = new PageContent($item);

    //     } else {

    //         throw new Exception("Trying to add something i don't understand");

    //     }

    //     if ($this->page->add($page_section)) {

    //         return $page_section;

    //     } else {

    //         throw new Exception("Something went wrong while adding the PageContent {$page_section->id} to Page {$this->page->id}");

    //     }
    // }

    // /**
    //  * Drop PageContent
    //  *
    //  * @param      \App\PageContent  $page_section  The navigation item
    //  */
    // public function drop($item)
    // {
    //     if (is_int($item)) {

    //         $page_section = $this->page->sections()->findOrFail($item);

    //     } else if ($item instanceof PageContent) {

    //         $page_section = $this->page->sections()->findOrFail($item->id);

    //     }

    //     if ($page_section->delete()) {

    //         return true;

    //     } else {

    //         throw new Exception("Errors while removing PageContent");

    //     }

    // }

}