<?php

namespace P3in\Builders;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Builders\PageLayoutBuilder;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Section;
use P3in\PublishFiles;
use P3in\Renderers\TemplateRenderer;

class PageBuilder
{
    /**
     * Page instance
     */
    private $page;
    private $container;
    private $section;

    public function __construct(Page $page = null)
    {
        if (!is_null($page)) {
            $this->page = $page;
        }
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


    /**
     * Adds a child.
     *
     * @param      <type>  $title  The title
     * @param      <type>  $slug   The slug
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function addChild($title, $slug)
    {
        $page = $this->page->createChild([
            'title' => $title,
            'slug' => $slug,
        ]);

        return new static($page);
    }

    /**
     * Add a Container to a page and return it's PageSectionContent model instance
     *
     * @param int $order Display order
     * @param array $config Container's attributes
     * @return PageSectionContent
     */
    public function addContainer(int $order = 0, array $config = [])
    {
        if ($this->container) {
            $container = $this->container->addContainer($order, $config);
        }else{
            $container = $this->page->addContainer($order, $config);
        }

        $this->container = $container;
        $this->section = null;

        return $this;
    }

    /**
     * Add a section to a container.
     *
     * @param      Section      $section
     * @param      int          $order
     * @param      array        $data     The data
     * @param      int   $columns
     *
     * @throws     Exception    (description)
     *
     * @return     PageBuilder
     */
    public function addSection(Section $section, int $order = 0, array $data = [])
    {
        if (!$this->container) {

            throw new Exception('a Container must be set to add Sections.');

        }

        $this->section = $this->container->addSection($section, $order, $data);

        return $this;
    }

    public function cloneTo(&$variable)
    {
        $variable = clone $this;

        return $this;
    }

    public function parent($ancestors = 1)
    {
        // Lots of overhead here but it does validate each step.
        for ($i=0; $i < $ancestors; $i++) {
            $child = $this->getContext();

            if (is_null($parent = $child->parent)) {
                throw new Exception("this instance of {get_class($child)} doesn't have a parent");
            }

            if ($parent instanceof PageSectionContent) {
                $this->container = $parent;
                $this->section = null;
            }elseif($parent instanceof Page) {
                $this->page = $parent;
            }else{
                throw new Exception("{get_class($parent)} not usable here");
            }

        }

        return $this;
    }

    private function getContext()
    {
        if ($this->section) {
            return $this->section;
        }elseif($this->container){
            return $this->container;
        }elseif($this->page){
            return $this->page;
        }else{
            throw new Exception('Must set a page, container, or section.');
        }
    }

    /**
     * Gets the page.
     *
     * @return     <type>  The page.
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the author.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function author($val = '')
    {
        // @NOTE: calls this->page->setMeta('head->author', $val);
        return $this->setMeta('head->author', $val);
    }

    /**
     * Sets the description.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function description($val = '')
    {
        return $this->setMeta('head->description', $val);
    }

    /**
     * Sets the priority.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function priority($val = '')
    {
        return $this->setMeta('priority', $val);
    }

    /**
     * Sets the updated frequency.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function updatedFrequency($val = '')
    {
        return $this->setMeta('update_frequency', $val);
    }

    /**
     * Sets the meta.
     *
     * @param      <type>  $key    The key
     * @param      <type>  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    // public function setMeta($key, $val)
    // {
    //     $this->page->setMeta($key, $val);

    //     return $this;
    // }

    public function renderTemplate(string $layout)
    {
        $renderer = new TemplateRenderer($this->page);

        $renderer->layout($layout)->render();


        return $this;
    }


    /**
     * Passthrough for building a MenuItem from the page
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function makeMenuItem($order)
    {
        return $this->page->makeMenuItem($order);
    }

    public function __call($method, $args)
    {
        if (method_exists($this->getContext(), $method)) {

            call_user_func_array([$this->getContext(), $method], $args);

        }

        return $this;
    }
}
