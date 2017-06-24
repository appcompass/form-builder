<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\PublishFiles;
use P3in\Storage;

class TemplateRenderer
{
    private $page;
    private $layout;
    private $sections = [];
    private $imports = [];
    private $exports = [];
    private $contents;

    public function __construct(Page $page, Storage $disk = null)
    {
        $this->page = $page;
        $this->disk = $disk ?? $page->website->getDisk();
    }

    public function getContents()
    {
        return $this->contents;
    }

    // public function layout(string $layout = null)
    // {
    //     $this->layout = $layout;
    //     return $this;
    // }

    /**
     * Render website page template.
     * @param string $layout
     * @param array $sections
     * @param array|array $imports
     * @return string
     */
    public function buildTemplate(array $sections = null, array $imports = null)
    {
        // $layout = $this->page->layout ?? $this->layout;

        // if (!$layout) {
        //     throw new \Exception('No page layout was defined for the page or to the renderer.  Please define a layout either on the page or to the template renderer.');
        // }
        return view('pilot-io::page', [
            'page' => $this->page,
            'meta' => $this->formatMeta(),
            'sections' => $sections ?? $this->sections,
            'imports' => $imports ?? $this->imports,
        ])->render();
    }

    private function formatMeta()
    {
        $rtn = [];
        foreach ($this->page->getMeta('head') as $key => $value) {
            $value = addslashes($value);
            $rtn[] = "{vmid: '{$key}', name: '{$key}', content: '$value'}";
        }
        return implode(', ', $rtn);
    }

    /**
     * Exports Page Template
     */
    public function render()
    {
        $pageStructure = $this->page->buildContentTree();

        $this->buildPageTemplateTree($pageStructure);
        $this->contents = $this->buildTemplate();
        return $this;
    }

    public function store()
    {
        $page = $this->page;
        $name = $page->url == '/' ? '/index' : '/'.str_replace('/', '-', trim($page->url, '/'));

        $this->storeTemplate($name);
        // //@TODO: On delete or parent change of a page (we use the url as the unique name for a page),
        // //we need to delete it's template file as to clean up junk.
    }

    public function compile()
    {
        $this->render()
        ->store();

        return $this;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $conf   The conf
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    private function compileElement(PageSectionContent $part, int $container) : string
    {
        $conf = $part->config;

        if ($container) {
            return $this->buildContainer($conf);
        } else {
            return $this->buildComponent($part);
        }

        return $elm;
    }

    private function buildContainer($conf) : string
    {
        $elm = $conf->elm ?? 'div';

        if (!empty($conf->class)) {
            $elm .= '.'.str_replace(' ', '.', $conf->class);
        }

        return $elm;
    }

    private function buildComponent(PageSectionContent $part) : string
    {
        $elm = $part->section->template;
        $props = $this->buildProps($part->config);

        $props[] = ':data="content['.$part->id.']"';

        return $elm.'('.implode(', ', $props).')';
    }

    /**
     * Builds the props for an element
     * @return array of strings
     */
    private function buildProps($conf) : array
    {
        $props = [];
        if (!empty($conf->props) && is_object($conf->props)) {
            foreach ($conf->props as $key => $val) {
                // creates this: :to="from"
                $props[] = ':'.$key.'="'.$val.'"';
            }
        }
        return $props;
    }

    /**
     * Gets the element data.
     *
     * @param      <type>  $depth  The depth
     * @param      <type>  $name   The name
     *
     * @return     array   The element data.
     */
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
            $has_children = $part->children->count();
            $template = $part->section->template;

            // build the element name for this page section content.
            $name = $this->compileElement($part, $has_children);

            $this->sections[] = $this->getElementData($depth, $name);

            if (!in_array($template, $this->imports)) {
                $this->imports[] = $template;
            }

            // add the container's children.
            if ($has_children) {
                $this->buildPageTemplateTree($part->children, $pos+1);
            }
        }
    }

    private function compileParentTemplate()
    {
        $sections = [$this->getElementData(0, '<router-view/>')];
        return $this->buildTemplate($sections);
    }

    public function storeTemplate($name)
    {
        if (!$this->contents) {
            throw new Exception('Template file has not been properly constructed');

        }
        if (!$this->disk) {
            throw new Exception('No Disk specified to store templates.');
        }
        $this->disk->put("/src/pages{$name}.vue", $this->contents);
    }
}
