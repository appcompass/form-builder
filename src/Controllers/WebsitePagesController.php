<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Interfaces\WebsitePagesRepositoryInterface;
use P3in\Models\PageSectionContent;
use P3in\Models\Section;
use P3in\Requests\FormRequest;

class WebsitePagesController extends AbstractChildController
{
    public function __construct(WebsitePagesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * show
     *
     * @param      <type>  $parent  The parent
     * @param      <type>  $model   The model
     *
     * @return     array   ( description_of_the_return_value )
     */
    public function show(FormRequest $request, Model $parent, Model $model)
    {
        // dd($model->);
        // dd($model->buildContentTree());
        $this->repo->raw_data = true;
        return $this->repo->output([
            'page' => $model->toArray(),
            'layout' => $model->buildContentTree(true)
        ]);
        // return [
        //     'page' => $model->toArray(),
        //     'data' => $model->buildContentTree(true)
        // ];
    }

    // @TODO: these should live in their own controllers
    // using a repo that manages Section model interface.
    public function containers(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($parent, true)
        ]);
    }

    public function sections(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($parent)
        ]);
    }

    private function getSections(Model $parent, $containers = false)
    {
        $sections = Section::where('type', $containers ? '=' : '!=', 'container')->where(function ($query) use ($parent) {
            $query->whereNull('website_id')
                    ->orWhere('website_id', $parent->id);
        })->with('form')->get();

        $rtn = [];
        foreach ($sections as $section) {
            $pageSectionContent = new PageSectionContent(['content' => '{}']);
            $rtn[] = $pageSectionContent->section()->associate($section);
        }

        return $rtn;
    }
}
