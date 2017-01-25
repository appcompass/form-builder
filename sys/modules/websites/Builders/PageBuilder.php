<?php

namespace P3in\Builders;

use P3in\Traits\PublishesComponentsTrait;
use P3in\Models\PageComponentContent;
use P3in\Builders\PageLayoutBuilder;
use P3in\Models\Component;
use P3in\Models\Page;
use Exception;
use Closure;

class PageBuilder
{
    use PublishesComponentsTrait;

    /**
     * Page instance
     */
    private $page;
    private $website; // we need this to know where we store this page's template files.
    private $container;
    private $template = [];
    private $imports = [];
    private $exports = [];

    public function __construct(Page $page = null)
    {
        if (!is_null($page)) {
            $this->page = $page;
            $this->website = $page->website;
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
     * Add a Container to a page and return it's PageComponentContent model instance
     *
     * @param int $columns Container's column span
     * @param int $order Display order
     * @return PageComponentContent
     */
    public function addContainer($columns = 1, $order = 0) : PageComponentContent
    {
        return $this->page->addContainer($columns, $order);
    }

    /**
     * Add a section to a container.
     * @param Component $component
     * @param int $columns
     * @param int $order
     * @return PageBuilder
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
        return $this->setMeta('author', $val);
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
        return $this->setMeta('description', $val);
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


    /**
     * Builds a page template tree.
     *
     * @param      <type>   $parts  The parts
     * @param      integer  $depth  The depth
     */
    private function buildPageTemplateTree($parts, int $tabs = 1)
    {
        $s = str_pad('', $tabs*2);

        foreach ($parts as $part) {
            $name = $part->component->template;

            if ($part->children->count() > 0) {
                $this->template[] = $s.'div.col-'.$part->columns;

                $this->buildPageTemplateTree($part->children, $tabs+1);
            } else {
                $this->template[] = $s.$name;

                $import = "  import {$name} from '~components/{$name}'";

                if (!in_array($import, $this->imports)) {
                    $this->imports[] = $import;
                    $this->exports[] = $name;
                }
            }
        }
    }

    /**
     * Exports Page Template
     */
    public function compilePageTemplate()
    {
        $page = $this->page;
        $manager = $this->getMountManager('pages');
        $name = $page->url == '/' ? '/index' : $page->url;
        $siteConfig = $this->website->config;
        //@TODO: On delete or parent change of a page (we use the url as the unique name for a page),
        //we need to delete it's component file as to$siteConfigclean up junk.
        $header = $siteConfig->header;
        $footer = $siteConfig->footer;

        // $this->template[] = "  {$header}";
        // $this->imports[] = "  import {$header} from './{$header}'";
        $this->buildPageTemplateTree($page->containers);
        // $this->template[] = "  {$footer}";
        // $this->imports[] = "  import {$footer} from './{$footer}'";

        $contents = '<template lang="jade">'."\n";
        $contents .= 'div'."\n";
        $contents .= implode("\n", $this->template)."\n";
        $contents .= '</template>'."\n\n";
        $contents .= '<script>'."\n";
        $contents .= implode("\n", $this->imports)."\n\n";
        $contents .= '  export default { components: { '.implode(', ', $this->exports)." } }\n";
        $contents .= '</script>'."\n";

        $manager->put('dest://' . $name.'.vue', $contents . "\n");
    }
}
