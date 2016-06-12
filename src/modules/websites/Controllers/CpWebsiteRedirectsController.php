<?php
namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Models\Redirect;
use P3in\Models\Website;

class CpWebsiteRedirectsController extends UiBaseController
{

    public $meta_install = [
        'classname' => Redirect::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.redirects.index',
                    'target' => '#record-detail',
                ],
            ],
        ],
        'edit' => [
            'heading' => 'Website Redirects Manager',
            'route' => 'websites.update',
            'description_title' => '',
            'description_text' => 'Use the below form to edit the website settings.',
            'dissallow_create_new' => true,
        ],
        'show' => [
            'sub_section_name' => 'Website Configuration',
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.edit',
                    'target' => '#record-detail',
                ]
            ],
        ],
    ];

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'websites';

        $this->setControllerDefaults();
    }

    /**
     *
     */
    public function index(Website $websites)
    {

        $redirects = Redirect::forWebsite($websites)->get();

        $this->meta->base_url = '/websites/' . $websites->id . '/redirects/';

        $meta = $this->meta;

        return view('websites::redirects.index', compact('redirects', 'meta'));
    }

    /**
     *
     */
    public function store(Request $request, Website $websites)
    {

        Redirect::forWebsite($websites)->truncate();

        foreach ($request->get('redirects') as $redirect) {

            $validator = \Validator::make($redirect,Redirect::$rules);

            if ($validator->fails()) {

                continue;

            }

            Redirect::updateOrCreate([
                'from' => $redirect['from'],
                'to' => $redirect['to'],
                'type' => $redirect['type'],
                'website_id' => $websites->id
            ]);

        }
        if ($websites->storeRedirects()) {
            return $this->json([], true, "Redirects successfully updated.");
        }
    }
}
