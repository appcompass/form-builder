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
        $menuitem = MenuItem::fromModel(Link::create($request->all()));

        $menuitem->save();

        return $menuitem;
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

    /**
     * @TODO Deletes a Link, not a menu! (those are deleted via websiteMenusController)
     * prob having a MenuLinks Controller would be more appropriate
     */
    public function deleteLink(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        $menu_items = MenuItem::whereNavigatableId($link->id)->whereNavigatableType(get_class($link))->get()->pluck('id');

        $link->delete();

        MenuItem::whereIn('id', $menu_items)->delete();

        // if ($link->delete() && ) {

        return response()->json(['message' => 'Model deleted.']);

        // } else {

            // throw new \Exception('Cannot delete Link.');

        // }

    }
}
