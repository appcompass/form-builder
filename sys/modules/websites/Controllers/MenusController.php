<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\MenusRepositoryInterface;
use P3in\Models\Link;
use P3in\Models\Form;
use P3in\Models\MenuItem;

class MenusController extends AbstractController
{
    public function __construct(MenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function show($model)
    {
        return $model->render();
    }

    // @TODO we only hit this on Link creation, menu creation must go through websites->menu
    public function store(Request $request)
    {
        // @TODO validate link
        return MenuItem::fromModel(Link::create($request->all()));
    }

    // have a method that returns the instance you wanna create with the form attached
    // so in this case like afterRoute does
    // @TODO this might be good use case for website getForms
    public function getForm(Request $request)
    {
        // @TODO validate menu request $request->website
        // @TODO link menus to website via pivot?
        $ret = Form::whereName($request->form)->firstOrFail();
        return $ret->fields;
    }
}
