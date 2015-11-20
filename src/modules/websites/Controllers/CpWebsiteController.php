<?php
namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteController extends UiBaseController
{
    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.index',
                    'target' => '#main-content-out',
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
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.show',
                    'target' => '#record-detail',
                ],
            ],
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
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Connection Information',
            'route' => 'websites.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'websites.create',
                    'target' => '#main-content-out',
                ],
            ],
            'heading' => 'Create New Site',
            'description_title' => 'Website Creation Form',
            'description_text' => 'Use this form to create a website, and configure it\'s web server',
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
                    'help_block' => 'The path to the SSH key authorized on the api remote server.',
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
                    'help_block' => 'The address of the reverse proxy as read from this website\'s server.',
                ],
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
        $this->module_name = 'websites';

        $this->setControllerDefaults();
    }

    /**
     *
     */
    public function index()
    {
        $this->records = Website::all();

        return $this->build('index', ['websites']);
    }

    /**
     *
     */
    public function create(Request $request)
    {
        return $this->build('create', ['websites']);
    }

    /**
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, Website::$validator_rules);


        $data = $request->all();

        $this->record = Website::create($data);

        $this->record->initRemote();

        return $this->json($this->setBaseUrl(['websites', $id, 'edit']));
    }

    /**
     *
     */
    public function show($id)
    {
        $this->record = Website::findOrFail($id);

        return $this->build('show', ['websites', $id]);
    }

    /**
     *
     */
    public function edit($id)
    {
        $this->record = Website::findOrFail($id);
        return $this->build('edit', ['websites', $id]);
    }

    /**
     *
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'site_name' => 'required|max:255', //|unique:websites // we need to do a unique if not self appproach.
            'site_url' => 'required',
            'config' => 'site_connection',
        ]);

        $data = $request->all();

        $this->record = Website::findOrFail($id);

        $this->record->update($data);

        $this->record->initRemote();

        return $this->json($this->setBaseUrl(['websites', $id, 'edit']));
    }

}