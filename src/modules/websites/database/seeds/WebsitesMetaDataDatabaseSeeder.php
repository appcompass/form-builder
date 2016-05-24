<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Field;
use P3in\Models\Form;
use P3in\Models\RouteMeta;

class WebsitesMetaDataDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the form builder object.
        $form = Form::firstOrNew([
            'name' => 'websites.settings',
        ]);

        $form->config = [];

        $form->save();



        $fieldset_break_field = Field::byName('fieldset_break');
        $text_field = Field::byName('text');
        $textarea_field = Field::byName('textarea');
        $file_field = Field::byName('file');
        $header_list_field = Field::byName('website_header_list');
        $footer_list_field = Field::byName('website_footer_list');
        $checkbox_field = Field::byName('checkbox');


        $form->fields()->detach();


        $form->fields()->save($fieldset_break_field, [
            'label' => 'Website Theme',
            'name' => 'website_theme',
            'config' => json_encode([
                'window_header' => '',
                'window_sub_header' => '',
            ]),
            'placeholder' => '',
            'help_block' => '',
            'order' => 1,
        ]);
        $form->fields()->save($file_field, [
            'label' => 'Website Logo',
            'name' => 'logo',
            'placeholder' => '',
            'help_block' => '',
            'order' => 2,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Primary Color',
            'name' => 'color_primary',
            'placeholder' => '#ffffff',
            'help_block' => '',
            'order' => 3,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Secondary Color',
            'name' => 'color_secondary',
            'placeholder' => '#ffffff',
            'help_block' => '',
            'order' => 4,
        ]);
        $form->fields()->save($header_list_field, [
            'label' => 'Website Header',
            'name' => 'header',
            'help_block' => 'Select the header style for this website.',
            'order' => 5,
        ]);
        $form->fields()->save($footer_list_field, [
            'label' => 'Website Footer',
            'name' => 'footer',
            'help_block' => 'Select the footer style for this website.',
            'order' => 6,
        ]);
        $form->fields()->save($checkbox_field, [
            'label' => 'Live',
            'name' => 'live',
            'help_block' => 'Check this box if the website is live.',
            'order' => 7,
        ]);

        $form->fields()->save($fieldset_break_field, [
            'label' => 'Website Default Header/Meta Data',
            'name' => 'website_default_meta_data',
            'config' => json_encode([
                'window_header' => '',
                'window_sub_header' => '',
            ]),
            'placeholder' => '',
            'help_block' => '',
            'order' => 10,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Default Title',
            'name' => 'meta_data[title]',
            'placeholder' => 'Page Meta Title',
            'help_block' => 'Leave this blank if you wish to use the Page Title above as the title.',
            'order' => 11,
        ]);
        $form->fields()->save($textarea_field, [
            'label' => 'Default Description',
            'name' => 'meta_data[description]',
            'placeholder' => 'Description Block',
            'help_block' => 'The title of the page.',
            'order' => 12,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Default Keywords',
            'name' => 'meta_data[keywords]',
            'placeholder' => 'Meta Keywords',
            'help_block' => 'The meta keywords of the page.',
            'order' => 13,
        ]);
        $form->fields()->save($textarea_field, [
            'label' => 'Custom Header HTML',
            'name' => 'custom_html_header',
            'placeholder' => '',
            'help_block' => '',
            'order' => 14,
        ]);
        $form->fields()->save($textarea_field, [
            'label' => 'robots.txt Content',
            'name' => 'robots_txt',
            'placeholder' => '',
            'help_block' => '',
            'order' => 15,
        ]);
        $form->fields()->save($fieldset_break_field, [
            'label' => 'Website Forms Settings',
            'name' => 'website_forms_settings',
            'config' => json_encode([
                'window_header' => '',
                'window_sub_header' => '',
            ]),
            'placeholder' => '',
            'help_block' => '',
            'order' => 20,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'From Email Address',
            'name' => 'from_email',
            'placeholder' => 'website@website.com',
            'help_block' => '',
            'order' => 21,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'From Email Name',
            'name' => 'from_name',
            'placeholder' => 'Website Name',
            'help_block' => '',
            'order' => 22,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'To Email Address',
            'name' => 'to_email',
            'placeholder' => 'catchall@website.com',
            'help_block' => 'This is the default email to address where if a form doesn\'t have a recipient specified, this address will be used.',
            'order' => 23,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'reCAPTCHA Site Key',
            'name' => 'recaptcha_site_key',
            'placeholder' => '',
            'help_block' => 'Use this in the HTML code your site serves to users.',
            'order' => 24,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'reCAPTCHA Secret Key',
            'name' => 'recaptcha_secret_key',
            'placeholder' => '',
            'help_block' => 'Use this for communication between your site and Google. Be sure to keep it a secret.',
            'order' => 25,
        ]);
        $form->fields()->save($fieldset_break_field, [
            'label' => 'Integrations',
            'name' => 'integrations',
            'config' => json_encode([
                'window_header' => '',
                'window_sub_header' => '',
            ]),
            'placeholder' => '',
            'help_block' => '',
            'order' => 30,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Google Analytics TRacking ID',
            'name' => 'ga_tracking_id',
            'placeholder' => 'UA-XXXXX-Y',
            'help_block' => '',
            'order' => 31,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Facebook App ID',
            'name' => 'facebook_app_id',
            'placeholder' => 'XXXXXXXXXXXXX',
            'help_block' => '',
            'order' => 32,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Facebook Page URL',
            'name' => 'facebook_page_url',
            'placeholder' => 'https://www.facebook.com/facebook',
            'help_block' => '',
            'order' => 33,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Twitter Page URL',
            'name' => 'twitter_page_url',
            'placeholder' => 'https://twitter.com/twitter',
            'help_block' => '',
            'order' => 34,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'LinkedIn Page URL',
            'name' => 'linkedin_page_url',
            'placeholder' => 'https://www.linkedin.com/company/linkedin',
            'help_block' => '',
            'order' => 35,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Google+ Page URL',
            'name' => 'google_plus_page_url',
            'placeholder' => 'https://plus.google.com/+google',
            'help_block' => '',
            'order' => 36,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Instagram Page URL',
            'name' => 'instagram_page_url',
            'placeholder' => 'https://www.instagram.com/instagram',
            'help_block' => '',
            'order' => 37,
        ]);
        $form->fields()->save($text_field, [
            'label' => 'Site Phone Number',
            'name' => 'site_phone_number',
            'placeholder' => 'https://www.instagram.com/instagram',
            'help_block' => '',
            'order' => 38,
        ]);






        // Seed the route details.
        $route = RouteMeta::firstOrNew([
                    'name' => 'websites.settings.index',
        ]);
        $route->config = [
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
        ];
        $route->save();

        $route = RouteMeta::firstOrNew([
                    'name' => 'websites.settings.show',
        ]);
        $route->config = [
            'heading' => 'Website Manager',
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
        ];
        $route->save();

        $route = RouteMeta::firstOrNew([
                    'name' => 'websites.settings.edit',
        ]);
        $route->config = [
            'heading' => 'Website Settings',
            'route' => 'websites.update',
            'description_title' => '',
            'description_text' => 'Use the below form to edit the website settings.',
            'dissallow_create_new' => true,
        ];
        $route->save();

        $route = RouteMeta::firstOrNew([
                    'name' => 'websites.settings.create',
        ]);
        $route->config = [
            'heading' => 'Create New Site',
            'route' => 'websites.settings.create'
        ];
        $route->save();
    }
}
