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

    /**
     * Fetch the requested form
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $form     The form
     *
     * @return     <type>                    The form.
     */
    public function getForm(Request $request, $form)
    {
        return \P3in\Models\FormButler::get($form);
    }

    /**
     * storeForm
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function storeForm(Request $request, $form_name)
    {
        return \P3in\Models\FormButler::store($form_name, $request->all());
    }

    /**
     * @TODO Deletes a Link, not a menu! (those are deleted via websiteMenusController)
     * prob having a MenuLinks Controller would be more appropriate
     */
    public function deleteLink(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        // @TODO move this in Link? who does housekeeping
        $menu_items = MenuItem::whereNavigatableId($link->id)->whereNavigatableType(get_class($link))->get()->pluck('id');

        // @TODO extend this method (meh) or add a 'deleting' listener (yay)
        $link->delete();

        MenuItem::whereIn('id', $menu_items)->delete();

        return response()->json(['message' => 'Model deleted.']);
    }
}
