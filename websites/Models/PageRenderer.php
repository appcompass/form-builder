<?php

namespace P3in\Models;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Models\Page;
use P3in\Models\PageSection;
use P3in\Models\Section;
use P3in\Models\Website;


/**
 * Examples:
 * new PageRenderer(Website::current())->render($url);
 */
class PageRenderer
{

    private $website;
    private $pages;
    private $page;
    private $build;

    public function __construct(Website $website)
    {
        $this->website = $website;
        $this->pages = $website->pages();


        return $this;
    }

    public function setPage($url)
    {
        if (is_string($url)) {

            $page = $this->getPageFromUrl($url);

        }else{
            throw new Exception('Must pass a url.');
        }

        $this->page = $page;

        return $this;
    }

    public function render($filtered = true)
    {

        if (!$this->page) {
            throw new Exception('A page must be set.');
        }

        $this->getSettings();
        $this->getContent($filtered);

        // structure the page data to be sent to the front-end to work out.
        return $this->build;
    }

    private function getSettings()
    {
        // fetch website settings that contain information on the website's header/footer/scripts/etc
        if ($settings = $this->website->settings) {
            $this->build['settings'] = $this->getModulesData($settings->modules);
        }else{
            throw new Exception('Website settings are not complete.');
        }
    }

    private function getModulesData($modulesSettings)
    {
        $rtn = [];
        foreach ($modulesSettings as $module_name => $settings) {
            $module = \Modular::get($module_name);
            // this logic should be abstracted to the moudularhandler,
            // problem with what's there now is that it loops through
            // all modules rather than just use the one requested.
            $method = 'getRenderData';
            if (!empty($module->class_name)) {
                $rtn[$module_name] = $this->callMethod($module->class_name, $method, [$settings]);
            }
        }
        return $rtn;
    }

    private function getContent($filtered = true)
    {
        // fetch and build the content of the page
        $contents = $this->page->contents->load('section.layout');

        // we only do this so toArray doesn't render stuff we don't want
        // displayed via most API calls, still may be good to be able to do
        // both, hency why I didn't make it permanent on the model.
        if ($filtered) {
            $this->cleanContents($contents);

            $contents->each(function($content){
                $this->cleanSections($content->section);
                $this->cleanLayouts($content->section->layout);
            });
        }

        foreach ($contents as &$content) {
            $config = $content->section->config;

            if (!empty($config->class) && !empty($config->method))
            {
                $content->content = $this->callMethod($config->class, $config->method, $content->content);
            }
        }

        $this->build['content'] = $contents->toArray(); //stuff
    }

    private function getPageFromUrl($url)
    {
        try {
            return $this->pages->byUrl($url)->firstorFail();
        } catch (Exception $e) {
            throw new Exception('There is no page by that URL.');
        }
    }

    private function cleanContents(&$contents)
    {
        $contents
            ->makeHidden('id')
            ->makeHidden('page_id')
            ->makeHidden('section_id');
    }

    private function cleanSections(&$sections)
    {
        $sections
            ->makeHidden('id')
            ->makeHidden('layout_id')
            ->makeHidden('form_id')
            ->makeHidden('config')
            ->makeHidden('created_at')
            ->makeHidden('updated_at')
            ;
    }

    private function cleanLayouts(&$layouts)
    {
        $layouts->makeHidden('id');
    }

    private function callMethod($class, $method, $params = null)
    {
        if (method_exists($class, $method)) {
            $instance = App::make($class);
            return call_user_func_array([$instance, $method], $params);
        }
    }
}