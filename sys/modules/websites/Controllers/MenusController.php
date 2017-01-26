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
        $link = Link::create($request->except(['children']));

        $menuitem = MenuItem::fromModel($link);

        $menuitem->save();

        $link->children = [];

        $menuitem->children = [];

        return ['link' => $link, 'menuitem' => $menuitem];
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
     * storeForm
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function storeForm(Request $request, $form_name)
    {
        $content = $request->all();

        switch ($content['type']) {
            case 'Link':
                MenuItem::findOrFail($content['id'])->navigatable()->update($content);
                break;
            case 'Page':
                MenuItem::findOrFail($content['id'])->update($content);
                break;
        }

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

        return response()->json(['message' => 'Model deleted.']);
    }
}
