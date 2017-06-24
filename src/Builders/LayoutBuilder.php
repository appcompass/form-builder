<?php

namespace P3in\Builders;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Layout;
use P3in\Models\PageSectionContent;
use P3in\Models\Resource;
use P3in\Models\Section;
use P3in\PublishFiles;
use P3in\Renderers\TemplateRenderer;

class LayoutBuilder
{
    /**
     * Layout instance
     */
    private $layout;
    private $container;
    private $section;

    public function __construct(Layout $layout = null)
    {
        if (!is_null($layout)) {
            $this->layout = $layout;
        }
    }


    /**
     * new
     *
     * @param      Page  $page   The Page
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public static function new(string $name, Website $website, Closure $closure = null)
    {
        $instance = new static();

        $instance->layout = $website->layouts()->create([
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
     * @throws     Exception   Layout must be set
     *
     * @return     LayoutBuilder  LayoutBuilder instance
     */
    public static function edit($layout)
    {
        if (!$layout instanceof Layout && !is_int($layout)) {
            throw new Exception('Must pass id or layout instance');
        }

        if (is_int($layout)) {
            $layout = Layout::findOrFail($layout);
        }

        return new static($layout);
    }

    public static function update($layout, $data)
    {
        $builder = static::edit($layout);

        if (!empty($data['deletions'])) {
            $builder->layout->dropChildren($data['deletions']);
        }

        $builder->layout->fill($data['info']);

        $builder->layout->save();

        $order = 0;
        $structueChange = false;
        $builder->fromStructure($data['layout'], null, $order, $structueChange);

        // @TODO: currently we have to manually run `npm install && npm run build` and if we're using something like PM2, `&& pm2 restart all`
        // Basically we have to redeploy the website because the templates have changed and thus means the bundles rebuilt.
        // We need to find a way to avoid having to do all that..
        if ($structueChange) {
            // @TODO: do we need to recompile pages too? or is that a seperate bundle?
            $builder->layout->website->renderer()->compile();
        }

    }

    public function fromStructure($array, $parent = null, &$order, &$structueChange)
    {

        foreach ($array as $row) {
            $order++;
            $layoutChild = $this->layout->children()->findOrNew($row['id'] ?? null);
            // @TODO: throw secific error so we know what to look for when debug is turned off.
            $section = Section::findOrFail($row['section']['id']);

            if ($layoutChild->getAttributeValue('order') != $order) {
                $structueChange = true;
            }

            $layoutChild->fill($row);
            $layoutChild->order = $order;

            $layoutChild->section()->associate($section);

            if ($parent) {
                $layoutChild->parent()->associate($parent);
            }
            // dd($layoutChild);
            $layoutChild->save();

            if (!empty($row['children'])) {
                $this->fromStructure($row['children'], $layoutChild, $order, $structueChange);
            }
        }
    }

    /**
     * Add a Container to a layout
     *
     * @param int $order Display order
     * @param array $config Container's attributes
     * @return LayoutBuilder
     */
    public function addContainer(Section $container = null)
    {
        if ($this->container) {
            $this->container = $this->container->addChild($container);
        } else {
            $this->container = $this->layout->addChild($container);
        }
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
        $this->section = $this->container->addChild($section);

        return $this;
    }


    public function parent($ancestors = 1)
    {
        // Lots of overhead here but it does validate each step.
        for ($i=0; $i < $ancestors; $i++) {
            $child = $this->getContext();

            if (is_null($parent = $child->parent)) {
                throw new Exception('this instance of '.get_class($child).' doesn\'t have a parent');
            }

            if ($parent instanceof Layout) {
                $this->container = $parent;
                $this->section = null;
            } else {
                throw new Exception(get_class($parent).' not usable here');
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
        } elseif ($this->layout) {
            return $this->layout;
        } else {
            throw new Exception('Must set a layout, container, or section.');
        }
    }

    /**
     * Gets the page.
     *
     * @return     <type>  The page.
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public function __call($method, $args)
    {
        if (method_exists($this->getContext(), $method)) {
            call_user_func_array([$this->getContext(), $method], $args);
        }

        return $this;
    }
}
