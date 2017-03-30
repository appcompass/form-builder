<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Interfaces\WebsitePagesRepositoryInterface;
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
            'collection' => Section::where('type', 'container')->where(function($query) use ($parent) {
                $query->whereNull('website_id')
                    ->orWhere('website_id', $parent->id);
            })->get()
        ]);
    }

    public function sections(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => Section::where('type', '!=', 'container')->where(function($query) use ($parent) {
                $query->whereNull('website_id')
                    ->orWhere('website_id', $parent->id);
            })->get()
        ]);
    }

}
