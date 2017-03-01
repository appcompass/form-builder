<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\PublishFiles;

class TemplateRenderer
{
    private $page;
    private $layout;
    private $sections = [];
    private $imports = [];
    private $exports = [];
    private $build;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function layout(string $layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Render website page template.
     * @param string $layout
     * @param array $sections
     * @param array|array $imports
     * @return string
     */
    public function buildTemplate(array $sections = null, array $imports = null)
    {
        return view('cms::page', [
            'layout' => $this->layout,
            'sections' => $sections ?? $this->sections,
            'imports' => $imports ?? $this->imports,
        ])->render();
    }

    /**
     * Exports Page Template
     */
    public function render()
    {
        $page = $this->page;
        $name = $page->url == '/' ? '/index' : $page->url;

        // //@TODO: On delete or parent change of a page (we use the url as the unique name for a page),
        // //we need to delete it's template file as to clean up junk.

        // build the parent template.
        if ($page->children->count()) {

            $this->storeTemplate($name, $this->compileParentTemplate());

            $name = $name.'/index';
        }

        $pageStructure = $page->buildContentTree();

        $this->buildPageTemplateTree($pageStructure);

        // build the child page template.
        $this->storeTemplate($name, $this->buildTemplate());

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
        }else{
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
        $sections = [$this->getElementData(0, '<nuxt-child/>')];
        return $this->buildTemplate($sections);
    }

    public function storeTemplate($name, $contents)
    {
        $disk = $this->page->website->storage->getDisk();

        // @TODO: redundant, disk can take care of storage of generated tempalte content.
        $manager = new PublishFiles('stubs', realpath(__DIR__.'/../Templates/stubs'));

        $manager->publishFile($disk, "/pages{$name}.vue", $contents, true);

    }
}
