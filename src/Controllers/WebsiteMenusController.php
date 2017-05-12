<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\FormButler;
use P3in\Models\Link;
use P3in\Models\MenuItem;
use P3in\Models\Page;
use P3in\Builders\MenuBuilder;

class WebsiteMenusController extends AbstractChildController
{
    public function __construct(WebsiteMenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function update(FormRequest $request, Model $parent, Model $menu)
    {
        return MenuBuilder::update($menu, $request->all());
    }

    public function storeLink(FormRequest $request, Model $parent)
    {
        // @TODO validate link
        $data = $request->except(['children']);

        $link = new Link($data);

        if (!$request->get('shared')) {
            $link->website()->associate($parent);
        }
        $link->save();

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
    public function getForm(FormRequest $request, Model $parent, $form_name)
    {
        return FormButler::get($form_name);
    }

    /**
     * storeForm
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function storeForm(FormRequest $request, Model $parent, $form_name)
    {
        return FormButler::store($form_name, $request->all());
    }

    /**
     * @TODO Deletes a Link, not a menu! (those are deleted via websiteMenusController)
     * prob having a MenuLinks Controller would be more appropriate
     */
    public function deleteLink(FormRequest $request, Model $parent, $id)
    {
        $link = Link::findOrFail($id);

        $menu_items = MenuItem::whereNavigatableId($link->id)->whereNavigatableType(get_class($link))->get()->pluck('id');

        $link->delete();

        MenuItem::whereIn('id', $menu_items)->delete();

        return ['message' => 'Model deleted.'];
    }
}
