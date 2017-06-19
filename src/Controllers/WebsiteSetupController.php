<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Interfaces\WebsiteSetupRepositoryInterface;
use P3in\Models\FormButler;
use P3in\Models\Link;
use P3in\Models\MenuItem;
use P3in\Models\Page;
use P3in\Builders\MenuBuilder;

class WebsiteSetupController extends AbstractController
{
    public function __construct(WebsiteSetupRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Fetch the requested form
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $form     The form
     *
     * @return     <type>                    The form.
     */
    public function getSetup(FormRequest $request, Model $parent)
    {
        return [];
    }
}
