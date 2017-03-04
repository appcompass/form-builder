<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
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
}
