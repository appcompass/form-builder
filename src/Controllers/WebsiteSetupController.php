<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Builders\MenuBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Interfaces\WebsiteSetupRepositoryInterface;
use P3in\Models\FormButler;
use P3in\Models\Link;
use P3in\Models\MenuItem;
use P3in\Models\Page;
use P3in\Requests\FormRequest;

class WebsiteSetupController extends AbstractController
{
    public function __construct(WebsiteSetupRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getSetup(FormRequest $request, Model $parent)
    {
        return $this->show($request, $parent);
    }

    public function postSetup(FormRequest $request, Model $parent)
    {
        // updated settings, checking validation etc.
        $update = $this->update($request, $parent);

        // run creation/deployment operations.
        $wb = WebsiteBuilder::edit($parent);

        // @TODO: change workflow back to storing and running directly on website disk instance.
        $wb->storePages()
            ->storeWebsite();

        // @TODO: find a good way to "minitor and display" the process as it runs.
        $wb->deploy();

        return $update;
    }
}
