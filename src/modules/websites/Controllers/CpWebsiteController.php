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
                    'Is Site Live?',
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
                    'is_live' => [
                        'type' => 'text',
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
                    'placeholder' => 'website.com',
                    'type' => 'text',
                    'help_block' => 'IMPORTANT: do not inclde the schema (https:// or http://), this is done automatically, only include the full hostname.',
                ],[
                    'label' => 'Hosting Platform',
                    'name' => 'hosting_instance',
                    'placeholder' => '',
                    'type' => 'selectlist',
                    'data' => ['local' => 'This Server'], //we make this dynamic later.
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
        $this->nav_name = 'websites';

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
        $servers = config('app.websites_deployment');

        if (!empty($servers[$request->hosting_instance])) {

            $config = $servers[$request->hosting_instance];
            $config['root'] = $config['vhost_root'].$request->site_url.'/';

            unset($config['vhost_root']);

            $data['config'] = $config;
            Website::testConnection($data['config'], true);
        }

        $this->record = Website::create($data);

        return $this->json($this->setBaseUrl(['websites', $this->record->id, 'settings']));
    }

    /**
     *
     */
    public function show(Website $websites)
    {
        $this->meta->show->sub_section_name = $websites->site_name.' '.$this->meta->show->sub_section_name;
        return $this->build('show', ['websites', $websites->id]);
    }

    /**
     *
     */
    public function edit(Website $websites)
    {
        $this->record = $websites;
        $this->meta->edit->heading = $websites->site_name.' '.$this->meta->edit->heading;

        // $this->authorize('edit', $this->record);

        return $this->build('edit', ['websites', $websites->id]);
    }

    /**
     *
     */
    public function update(Request $request, Website $websites)
    {

        $this->validate($request, Website::$rules);

        $data = $request->except(['_method','_token']);

        $servers = config('app.websites_deployment');

        if (!empty($servers[$request->hosting_instance])) {

            $config = $servers[$request->hosting_instance];
            $config['root'] = $config['vhost_root'].$request->site_url;

            unset($config['vhost_root']);

            $data['config'] = $config;
        }

        if ($websites->testConnection($data['config'], true)) {
            $websites->update($data);

            $websites->touch(); // make sure we trigger the ::updated event0

            return $this->json($this->setBaseUrl(['websites', $websites->id, 'edit']));
        }

        return $this->json([], false, 'Unable to connect, please verify connection details.');

    }

    public function list()
    {
        return Website::managed()->isLive()->get()->toJson();
    }

}
