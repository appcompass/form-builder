<?php

namespace P3in\Builders;

use Closure;
use Exception;
use P3in\Builders\PageLayoutBuilder;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\PageContent;
use P3in\Models\Section;

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

    public function setLayout(Layout $layout, $order = 1, Closure $closure = null)
    {
        $this->page->layouts()->attach($layout, ['order' => $order]);

        if ($closure) {
            $instance = new PageLayoutBuilder($this->page, $order, $layout);

            $closure($instance);

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