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

class PageBuilder
{
    /**
     * Page instance
     */
    private $page;
    private $website; // we need this to know where we store this page's template files.
    private $container;
    private $template = [];
    private $imports = [];
    private $exports = [];
    private $manager;

    public function __construct(Page $page = null)
    {
        if (!is_null($page)) {
            $this->page = $page;
            // set the destination path for all website pages.
            $siteDir = strtolower(str_slug($page->website->host));
            $fullPath = realpath(App::make('path.websites')).'/'.$siteDir.'/pages';

            $this->manager = new PublishFiles('dest', $fullPath);
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
    public function addContainer(int $order = 0, array $config = null) : PageSectionContent
    {
        return $this->page->addContainer($order, $config);
    }

    /**
     * Add a section to a container.
     * @param Section $section
     * @param int $columns
     * @param int $order
     * @return PageBuilder
     */
    public function addSection(Section $section, int $order, array $data = [])
    {
        if ($this->container) {
            $this->container->addSection($section, $order, $data);
            return $this;
        } else {
            throw new Exception('a Container must be set to add Sections.');
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
    public function setAuthor($val = '')
    {
        return $this->setMeta('head->author', $val);
    }

    /**
     * Sets the description.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setDescription($val = '')
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
    public function setPriority($val = '')
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
    public function setUpdatedFrequency($val = '')
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
    public function setMeta($key, $val)
    {
        $this->page->setMeta($key, $val);

        return $this;
    }

    private function compileElement($conf)
    {
        $elm = !empty($conf->elm) ? $conf->elm : 'div';

        if (!empty($conf->class)) {
            $elm .= '.'.str_replace(' ', '.', $conf->class);
        }
        return $elm;
    }
    private function getElementData($depth, $name)
    {
        return [
            'depth' => $depth,
            'value' => $name,
        ];
    }
    /**
     * Builds a page template tree.
     *
     * @param      <type>   $parts  The parts
     * @param      integer  $depth  The depth
     */
    private function buildPageTemplateTree($parts, int $pos = 0)
    {
        $depth = $pos*2;

        foreach ($parts as $part) {
            if ($part->children->count() > 0) {
                // build the element name for this container.
                $name = $this->compileElement($part->config);

                $this->template[] = $this->getElementData($depth, $name);
                // add the container's children.
                $this->buildPageTemplateTree($part->children, $pos+1);
            } else {
                $name = $part->section->template;
                $props = $part->buildProps();
                $props[] = ':data="content['.$part->id.']"';
                $dataAppend = '('.implode(', ', $props).')';
                $this->template[] = $this->getElementData($depth, $name.$dataAppend);

                if (!in_array($name, $this->imports)) {
                    $this->imports[] = $name;
                }
            }
        }
    }
    /**
     * Render website page template.
     * @param string $layout
     * @param array $sections
     * @param array|array $imports
     * @return string
     */
    public static function buildTemplate(string $layout, array $sections, array $imports = [])
    {
        return view('websites::page', [
            'layout' => $layout,
            'sections' => $sections,
            'imports' => $imports,
        ])->render();
    }

    /**
     * Exports Page Template
     */
    // @TODO: the use of $this->manager has been abstracted to the PublishFiles class, which will eventually become part of the Deploy family.
    public function compilePageTemplate($layout)
    {
        $page = $this->page;
        $name = $page->url == '/' ? '/index' : $page->url;

        // //@TODO: On delete or parent change of a page (we use the url as the unique name for a page),
        // //we need to delete it's template file as to clean up junk.

        // // this is prob not needed, right now some sections have two or more
        // // same level sections.  that doesn't jive well with the template structure.
        // // We might want to break the templates up into smaller pieces, but for now
        // // we just have a container div as the parent on all pages.
        // $this->template[] = $this->getElementData(0, 'div');

        if ($page->children->count()) {
            $sections = [$this->getElementData(0, '<nuxt-child/>')];

            $parent_template = static::buildTemplate($layout, $sections);

            $this->manager->publishFile('dest', $name.'.vue', $parent_template, true);
            $name = $name.'/index';
        }

        $this->buildPageTemplateTree($page->containers);

        // dd(json_encode($this->exports));
        // handling child page structures.

        $contents = static::buildTemplate($layout, $this->template, $this->imports);

        $this->manager->publishFile('dest', $name.'.vue', $contents, true);
    }
}
