<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Requests\FormRequest;
use P3in\Interfaces\WebsitePagesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

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
        return [
            'page' => $model->toArray(),
            'data' => $model->buildContentTree(true)
        ];
    }
}
