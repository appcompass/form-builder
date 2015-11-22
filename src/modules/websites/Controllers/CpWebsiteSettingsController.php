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
            'heading' => 'Connection Information',
            'route' => 'websites.update'
        ],
        'create' => [
            'heading' => 'Create New Site',
            'route' => '/websites'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'Name',
                    'name' => 'site_name',
                    'placeholder' => 'Website.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'URL',
                    'name' => 'site_url',
                    'placeholder' => 'https://www.website.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'From Email Address',
                    'name' => 'config[from_email]',
                    'placeholder' => 'website@website.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'From Email Name',
                    'name' => 'config[from_name]',
                    'placeholder' => 'Website Name',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'A Managed Website',
                    'name' => 'config[managed]',
                    'placeholder' => '',
                    'type' => 'checkbox',
                    'help_block' => '',
                ],[
                    'label' => 'SSH Host',
                    'name' => 'config[ssh_host]',
                    'placeholder' => '127.0.0.1',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'SSH Username',
                    'name' => 'config[ssh_username]',
                    'placeholder' => 'username',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Path to SSH Secret Key',
                    'name' => 'config[ssh_key]',
                    'placeholder' => '/home/webmanageruser/.ssh/id_rsa',
                    'type' => 'text',
                    'help_block' => 'Must use either SSH Key or SSH Password above (key is preferable).',
                ],[
                    'label' => 'SSH Key Phrase',
                    'name' => 'config[ssh_keyphrase]',
                    'placeholder' => 'idrsa_key_passphrase',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Website Document Root',
                    'name' => 'config[ssh_root]',
                    'placeholder' => '/path/to/document/root',
                    'type' => 'text',
                    'help_block' => '',
                /*
                ],[
                    'label' => 'Nginx Server Name',
                    'name' => 'config[server][server_name]',
                    'placeholder' => 'www.sitename.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Nginx Server Error Log Path',
                    'name' => 'config[server][error_log_path]',
                    'placeholder' => '/var/logs/www-sitename-com.log',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Strict SSL Params',
                    'name' => 'config[server][server_ssl][strict]',
                    'placeholder' => '',
                    'type' => 'radio',
                    'data' => [
                        'Yes' => 1,
                        'No' => 0,
                    ],
                    'help_block' => '',
                ],[
                    'label' => 'Nginx Server SSL Cert Path',
                    'name' => 'config[server][server_ssl][cert_path]',
                    'placeholder' => '/path/to/cert',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Nginx Server SSL Cert Key Path',
                    'name' => 'config[server][server_ssl][cert_key_path]',
                    'placeholder' => '/path/to/cert.key',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'SSL dhparam.pem Path',
                    'name' => 'config[server][server_ssl][ssl_dhparam]',
                    'placeholder' => '/path/to/dhparam.pem',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Nginx Server Reverse Proxy URL',
                    'name' => 'config[server][proxy_url]',
                    'placeholder' => 'https://127.0.0.1:4433',
                    'type' => 'text',
                    'help_block' => '',
                */
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
        $website = Website::findOrFail($website_id);

        return view('websites::settings/index', compact('website'))
            ->with('settings', $website->settings->data)
            ->with('headers', Section::headers()->get()->lists('name', 'id'))
            ->with('footers', Section::footers()->get()->lists('name', 'id'));
    }

    /**
     *
     */
    public function create($website_id)
    {
        $parent = Website::findOrFail($website_id);
        return view('websites::settings/create', compact('parent'));
    }

    /**
     *
     */
    public function store(Request $request, $website_id)
    {

        $website = Website::findOrFail($website_id);

        $data = $request->except(['_token', '_method']);

        $records = $website->settings($data);

        try {

            $website->deploy();

            return $this->json($this->setBaseUrl(['websites', $website_id, 'pages']));

        } catch (\RuntimeException $e) {

            \Log::error("Error while deploying $website->site_name: ".$e->getMessage());

            return $this->json([], false, 'Error during deployment. Please contact us.' );

        }

    }

    /**
     *
     *
     */
    public function update(Request $request, $website_id)
    {
        // $website = Website::findOrFail($website_id);
    }

    /**
     *
     */
    public function show($website_id, $id)
    {

        $parent = Website::findOrFail($website_id);
        $records = $parent->settings(); //id ?

        return view('websites::settings/show', compact('parent', 'records'));
    }

}