<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\MenusRepositoryInterface;
use P3in\Models\Form;
use P3in\Models\FormButler;
use P3in\Models\Link;
use P3in\Models\MenuItem;
use P3in\Requests\FormRequest;

class MenusController extends AbstractController
{
    public function __construct(MenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function show(FormRequest $request, Model $model)
    {
        $permisions = [];

        if (\Auth::check()) {
            $permissions = \Auth::user()->allPermissions();
        }

        return $model->render(false, $permissions);
    }

    // @TODO we only hit this on Link creation, menu creation must go through websites->menu
    public function store(FormRequest $request)
    {
        // @TODO validate link
        $data = $request->except(['children']);

        $link = new Link($data);

        // if (!$request->get('shared')) {
        //     $link->
        // }

        dd($link);


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
    public function getForm(FormRequest $request, $form_name)
    {
        return FormButler::get($form_name);
    }

    /**
     * storeForm
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function storeForm(FormRequest $request, $form_name)
    {
        return FormButler::store($form_name, $request->all());
    }

    /**
     * @TODO Deletes a Link, not a menu! (those are deleted via websiteMenusController)
     * prob having a MenuLinks Controller would be more appropriate
     */
    public function deleteLink(FormRequest $request, $id)
    {
        $link = Link::findOrFail($id);

        $menu_items = MenuItem::whereNavigatableId($link->id)->whereNavigatableType(get_class($link))->get()->pluck('id');

        $link->delete();

        MenuItem::whereIn('id', $menu_items)->delete();

        return ['message' => 'Model deleted.'];
    }
}
