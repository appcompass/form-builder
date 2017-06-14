<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsitesRepositoryInterface;

class WebsitesController extends AbstractController
{
    public function __construct(WebsitesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    // @TODO: these should live in their own controllers
    // using a repo that manages Section model interface.
    public function containers(FormRequest $request, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($model, true)
        ]);
    }

    public function sections(FormRequest $request, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($model)
        ]);
    }

    private function getSections(Model $model, $containers = false)
    {
        $sections = Section::where('type', $containers ? '=' : '!=', 'container')->where(function ($query) use ($model) {
            $query->whereNull('website_id')
                    ->orWhere('website_id', $model->id);
        })->with('form')->get();
        $rtn = [];
        foreach ($sections as $section) {
            $pageSectionContent = new PageSectionContent(['content' => '{}']);
            $rtn[] = $pageSectionContent->section()->associate($section);
        }

        return $rtn;
    }

    public function pageLinks(FormRequest $request, Model $model)
    {
        return response()->json([
            'collection' => $model->pages
        ]);
    }

    public function externalLinks(FormRequest $request, Model $model)
    {
        // @TODO: $model->links instead of Link::get()
        return response()->json([
            'collection' => Link::get()
        ]);
    }
}
