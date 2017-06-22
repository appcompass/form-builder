<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Builders\MenuBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Interfaces\WebsiteSetupRepositoryInterface;
use P3in\Jobs\DeployWebsite;
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

        dispatch((new DeployWebsite($parent))->onQueue('deployments'));

        return $update;
    }
}
