<?php

namespace P3in\Builders;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Resource;
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

    public static function update($page, $data)
    {
        $builder = static::edit($page);

        if (!empty($data['deletions'])) {
            $builder->page->dropContent($data['deletions']);
        }

        // for home page where slug is empty string, sometimes comes back as null as result.
        $data['page']['slug'] = $data['page']['slug'] ?? '';

        $builder->page->fill($data['page']);

        $builder->page->save();

        $order = 0;
        $structueChange = false;
        $builder->fromStructure($data['layout'], null, $order, $structueChange);

        // @TODO: currently we have to manually run `npm install && npm run build` and if we're using something like PM2, `&& pm2 restart all`
        // Basically we have to redeploy the website because the templates have changed and thus means the bundles rebuilt.
        // We need to find a way to avoid having to do all that..
        if ($structueChange) {
            // re-render the template.
            $builder->storePage();
            // Store the website when page structure has changed.
            // @TODO: shouldn't be necisary.
            $builder->storeWebsite();
        }

    }

    public function fromStructure($array, $parent = null, &$order, &$structueChange)
    {

        foreach ($array as $row) {
            $order++;
            $pageContentSection = $this->page->contents()->findOrNew($row['id'] ?? null);
            // @TODO: throw secific error so we know what to look for when debug is turned off.
            $section = Section::findOrFail($row['section']['id']);

            if ($pageContentSection->getAttributeValue('order') != $order) {
                $structueChange = true;
            }

            $pageContentSection->fill($row);
            $pageContentSection->order = $order;

            $pageContentSection->section()->associate($section);

            if ($parent) {
                $pageContentSection->parent()->associate($parent);
            }
            // dd($pageContentSection);
            $pageContentSection->save();

            if (!empty($row['children'])) {
                $this->fromStructure($row['children'], $pageContentSection, $order, $structueChange);
            }
        }
    }

    /**
     * Adds a child.
     *
     * @param      <type>  $title  The title
     * @param      <type>  $slug   The slug
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function addChild($title, $slug, $dynamic = false)
    {
        $page = $this->page->createChild([
            'title' => $title,
            'slug' => $slug,
            'dynamic_url' => $dynamic,
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
    public function addContainer(Section $container = null)
    {
        if ($this->container) {
            $container = $this->container->addContainer($container);
        } else {
            $container = $this->page->addContainer($container);
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
    public function addSection(Section $section)
    {
        if ($this->container) {
            $this->section = $this->container->addSection($section);
        } else {
            $this->section = $this->page->addSection($section);
        }

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
            } elseif ($parent instanceof Page) {
                $this->page = $parent;
            } else {
                throw new Exception("{get_class($parent)} not usable here");
            }
        }

        return $this;
    }

    private function getContext()
    {
        if ($this->section) {
            return $this->section;
        } elseif ($this->container) {
            return $this->container;
        } elseif ($this->page) {
            return $this->page;
        } else {
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
        return $this->setMeta('sitemap->priority', $val);
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
        return $this->setMeta('sitemap->changefreq', $val);
    }

    public function layout($layout = null)
    {
        $this->page->update(['layout' => $layout]);

        return $this;
    }

    /**
     * Sets the resource.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function resource($val = '')
    {
        return $this->setMeta('resource', $val);
    }

    /**
     * Sets the requiresAuth.
     *
     * @param      string  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function requiresAuth($val = true)
    {
        return $this->setMeta('requiresAuth', $val);
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

    public function storePage(string $layout = null)
    {
        $renderer = new TemplateRenderer($this->page);

        $renderer
        // ->layout($layout)
        ->render()
        ->store();


        return $this;
    }

    public function storeWebsite()
    {
        $builder = WebsiteBuilder::edit($this->page->website);
        $builder->storeWebsite();
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
