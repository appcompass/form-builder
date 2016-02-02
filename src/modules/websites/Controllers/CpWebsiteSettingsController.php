<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\Section;
use P3in\Models\Website;

class CpWebsiteSettingsController extends UiBaseController
{
    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.settings.index',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Manage Websites',
            'table' => [
                'headers' => [
                    'Name',
                    'Site URL',
                    'Created',
                    'Updated',
                ],
                'rows' => [
                    'site_name' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
                    ],
                    'site_url' => [
                        'type' => 'link_to_blank',
                    ],
                    'created_at' => [
                        'type' => 'datetime',
                    ],
                    'updated_at' => [
                        'type' => 'datetime',
                    ],
                ],
            ],
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
        'edit' => [
            'heading' => 'Website Settings',
            'route' => 'websites.update',
            'description_title' => '',
            'description_text' => 'Use the below form to edit the website settings.',
            'dissallow_create_new' => true,
        ],
        'create' => [
            'heading' => 'Create New Site',
            'route' => 'websites.settings.create'
        ],
        'form' => [
            'fields' => [
                [
                    'type' => 'fieldset_break',
                    'window_title' => 'Website Theme',
                    'window_header' => '',
                    'window_sub_header' => '',
                ],[
                    'label' => 'Website Logo',
                    'name' => 'logo',
                    'placeholder' => '',
                    'type' => 'file',
                    'help_block' => '',
                ],[
                    'label' => 'Primary Color',
                    'name' => 'color_primary',
                    'placeholder' => '#ffffff',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Secondary Color',
                    'name' => 'color_secondary',
                    'placeholder' => '#ffffff',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Website Header',
                    'name' => 'header',
                    'type' => 'filtered_selectlist',
                    'data' => 'header_list',
                    'help_block' => 'Select the header style for this website.',
                ],[
                    'label' => 'Website Footer',
                    'name' => 'footer',
                    'type' => 'filtered_selectlist',
                    'data' => 'footer_list',
                    'help_block' => 'Select the footer style for this website.',
                ],[
                    'type' => 'fieldset_break',
                    'window_title' => 'Website Default Header/Meta Data',
                    'window_header' => '',
                    'window_sub_header' => '',
                ],[
                    'label' => 'Default title',
                    'name' => 'default_title',
                    'placeholder' => '',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Default Description',
                    'name' => 'default_description',
                    'placeholder' => '',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Default Keywords',
                    'name' => 'default_keywords',
                    'placeholder' => '',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Custom Header HTML',
                    'name' => 'custom_html_header',
                    'placeholder' => '',
                    'type' => 'textarea',
                    'help_block' => '',
                ],[
                    'label' => 'robots.txt Content',
                    'name' => 'robots_txt',
                    'placeholder' => '',
                    'type' => 'textarea',
                    'help_block' => '',
                ],[
                    'type' => 'fieldset_break',
                    'window_title' => 'Website Forms Settings',
                    'window_header' => '',
                    'window_sub_header' => '',
                ],[
                    'label' => 'From Email Address',
                    'name' => 'from_email',
                    'placeholder' => 'website@website.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'From Email Name',
                    'name' => 'from_name',
                    'placeholder' => 'Website Name',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'To Email Address',
                    'name' => 'to_email',
                    'placeholder' => 'catchall@website.com',
                    'type' => 'text',
                    'help_block' => 'This is the default email to address where if a form doesn\'t have a recipient specified, this address will be used.',
                ],[
                    'label' => 'reCAPTCHA Site Key',
                    'name' => 'recaptcha_site_key',
                    'placeholder' => '',
                    'type' => 'text',
                    'help_block' => 'Use this in the HTML code your site serves to users.',
                ],[
                    'label' => 'reCAPTCHA Secret Key',
                    'name' => 'recaptcha_secret_key',
                    'placeholder' => '',
                    'type' => 'text',
                    'help_block' => 'Use this for communication between your site and Google. Be sure to keep it a secret.',
                ],[
                    'type' => 'fieldset_break',
                    'window_title' => 'Integrations',
                    'window_header' => '',
                    'window_sub_header' => '',
                ],[
                    'label' => 'Google Analytics TRacking ID',
                    'name' => 'ga_tracking_id',
                    'placeholder' => 'UA-XXXXX-Y',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Facebook App ID',
                    'name' => 'facebook_app_id',
                    'placeholder' => 'XXXXXXXXXXXXX',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Facebook Page URL',
                    'name' => 'facebook_page_url',
                    'placeholder' => 'https://www.facebook.com/facebook',
                    'type' => 'text',
                    'help_block' => '',
                ],
            ],
        ],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'websites';

        $this->setControllerDefaults();
    }

    /**
     *
     */
    public function index($website_id)
    {

        // $website = Website::managedById($website_id);

        // return view('websites::settings/index', compact('website'))
        //     ->with('settings', $website->settings->data)
        //     ->with('headers', Section::headers()->get()->lists('name', 'id'))
        //     ->with('footers', Section::footers()->get()->lists('name', 'id'));


        $website = Website::managedById($website_id);
        $this->record = $website->settings->data;

        if (isset($this->record->logo) && !is_string($this->record->logo)) {
            $this->record->logo = '';
        }
        $this->meta->header_list = Section::headers()->orderBy('name')->get()->lists('name', 'id');
        $this->meta->footer_list = Section::footers()->orderBy('name')->get()->lists('name', 'id');

        return $this->build('edit', ['websites', $website_id, 'settings', $website->settings->id]);
    }

    /**
     *
     */
    public function create($website_id)
    {
        $parent = Website::managedById($website_id);
        return view('websites::settings/create', compact('parent'));
    }

    /**
     *
     */
    public function store(Request $request, $website_id)
    {

        $website = Website::managedById($website_id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('logo')) {
            $logo = $website->addLogo($request->file('logo'));
            $data['logo'] = $logo->path;
        }

        $records = $website->settings($data);

        try {

            $website->deploy();

        } catch (\RuntimeException $e) {

            \Log::error("Error while deploying $website->site_name: ".$e->getMessage());

            return $this->json([], false, 'Error during deployment. Please contact us.' );

        }

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages']));

    }

    /**
     *
     *
     */
    public function update(Request $request, $website_id)
    {
        return $this->store($request, $website_id);
        // $website = Website::managedById($website_id);
    }

    /**
     *
     */
    public function show($website_id, $id)
    {

        $parent = Website::managedById($website_id);
        $records = $parent->settings(); //id ?

        return view('websites::settings/show', compact('parent', 'records'));
    }

}