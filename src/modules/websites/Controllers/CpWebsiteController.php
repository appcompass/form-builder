<?php
namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteController extends UiBaseController
{
    public $meta_install = [
        'classname' => Website::class,
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
            // 'data_targets' => [
            //     [
            //         'route' => 'websites.show',
            //         'target' => '#main-content-out',
            //     ],[
            //         'route' => 'websites.show',
            //         'target' => '#record-detail',
            //     ],
            // ],
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
            'heading' => 'Website Setup',
            'route' => 'websites.update',
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
            'route' => 'websites.store'
        ],
        'form' => [
            'fields' => [
                [
                    'type' => 'fieldset_break',
                    'window_title' => 'Basic Info',
                    'window_header' => '',
                    'window_sub_header' => '',
                ],[
                    'label' => 'Name',
                    'name' => 'site_name',
                    'placeholder' => 'Website.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'URL',
                    'name' => 'site_url',
                    'placeholder' => 'www.website.com',
                    'type' => 'text',
                    'help_block' => 'IMPORTANT: do not inclde the schema (https:// or http://), this is done automatically, only include the full hostname.',
                ],[
                    'type' => 'fieldset_break',
                    'window_title' => 'Server Connection',
                    'window_header' => 'Server Connection',
                    'window_sub_header' => 'Server Connection information',
                ],[
                    'label' => 'SSH Host',
                    'name' => 'config[host]',
                    'placeholder' => '127.0.0.1',
                    'type' => 'text',
                    'help_block' => 'Deployment target host IP Address.',
                ],[
                    'label' => 'SSH Username',
                    'name' => 'config[username]',
                    'placeholder' => 'username',
                    'type' => 'text',
                    'help_block' => 'Authentication can happen via Username / Password or Private Key / Passphrase combinations.',
                ],[
                    'label' => 'Path to SSH Secret Key',
                    'name' => 'config[privateKey]',
                    'placeholder' => '/path/to/id_rsa',
                    'type' => 'text',
                    'help_block' => 'Optionally connect using your pre-authorized private key.',
                ],[
                    'label' => 'SSH Password / SSH Key Phrase',
                    'name' => 'config[password]',
                    'placeholder' => 'SSH Password or Private Key Passphrase',
                    'type' => 'password',
                    'help_block' => 'SSH Password or Private Key Passphrase.',
                ],[
                    'label' => 'Website Document Root',
                    'name' => 'config[root]',
                    'placeholder' => '/path/to/document/root',
                    'type' => 'text',
                    'help_block' => '',
                // ],[
                //     'label' => 'Nginx Server Name',
                //     'name' => 'config[server][server_name]',
                //     'placeholder' => 'www.sitename.com',
                //     'type' => 'text',
                //     'help_block' => '',
                // ],[
                //     'label' => 'Nginx Server Error Log Path',
                //     'name' => 'config[server][error_log_path]',
                //     'placeholder' => '/var/logs/www-sitename-com.log',
                //     'type' => 'text',
                //     'help_block' => '',
                // ],[
                //     'label' => 'Strict SSL Params',
                //     'name' => 'config[server][server_ssl][strict]',
                //     'placeholder' => '',
                //     'type' => 'radio',
                //     'data' => [
                //         'Yes' => 1,
                //         'No' => 0,
                //     ],
                //     'help_block' => '',
                // ],[
                //     'label' => 'Nginx Server SSL Cert Path',
                //     'name' => 'config[server][server_ssl][cert_path]',
                //     'placeholder' => '/path/to/cert',
                //     'type' => 'text',
                //     'help_block' => '',
                // ],[
                //     'label' => 'Nginx Server SSL Cert Key Path',
                //     'name' => 'config[server][server_ssl][cert_key_path]',
                //     'placeholder' => '/path/to/cert.key',
                //     'type' => 'text',
                //     'help_block' => '',
                // ],[
                //     'label' => 'SSL dhparam.pem Path',
                //     'name' => 'config[server][server_ssl][ssl_dhparam]',
                //     'placeholder' => '/path/to/dhparam.pem',
                //     'type' => 'text',
                //     'help_block' => '',
                // ],[
                //     'label' => 'Nginx Server Reverse Proxy URL',
                //     'name' => 'config[server][proxy_url]',
                //     'placeholder' => 'https://127.0.0.1:4433',
                //     'type' => 'text',
                //     'help_block' => 'The address of the reverse proxy as read from this website\'s server.',
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
        $this->records = Website::managed()->get();

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
        $this->validate($request, Website::$rules);

        $data = $request->all();

        $this->record = Website::create($data);

        return $this->json($this->setBaseUrl(['websites', $this->record->id, 'settings']));
    }

    /**
     *
     */
    public function show($id)
    {
        $this->record = Website::managedById($id);

        return $this->build('show', ['websites', $id]);
    }

    /**
     *
     */
    public function edit($id)
    {
        $this->record = Website::managedById($id);

        $this->authorize('edit', $this->record);

        return $this->build('edit', ['websites', $id]);
    }

    /**
     *
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'site_name' => 'required|max:255',
            'site_url' => 'required',
            'config.host' => 'required:ip',
            'config.username' => 'required',
            'config.root' => 'required',
        ]);

        $website = $this->record = Website::managedById($id);

        $data = $request->except(['_method','_token']);

        if (!$data['config']['privateKey']) {

            $data['config']['password'] = $data['config']['password'] ?: !empty($website->config->password) ? $website->config->password : '';

        }

        if ($website->testConnection($data['config'], true)) {

            $website->update($data);

            return $this->json($this->setBaseUrl(['websites', $id, 'edit']));
        }

        return $this->json([], false, 'Unable to connect, please verify connection details.');

    }

}