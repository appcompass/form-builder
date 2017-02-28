<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;
use P3in\Models\Plus3Person;
use P3in\Models\Section;
use P3in\Models\Website;
use P3in\Seeders\Plus3PeopleSeeder;
use P3in\Seeders\Plus3websiteSectionsAndFormsSeeder;
use P3in\Seeders\Plus3websiteStoragesSeeder;

class Plus3websiteModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // this moves here otherwise we can't unlink storage instances
        DB::table('websites')->where('host', 'www.plus3interactive.com')->delete();

        $this->call(Plus3websiteStoragesSeeder::class);
        $this->call(Plus3PeopleSeeder::class);
        $this->call(Plus3websiteSectionsAndFormsSeeder::class);

        $website = WebsiteBuilder::new('Plus 3 Interactive, LLC', 'https', 'www.plus3interactive.com', function ($wsb) {

            // Get the sections used by this website.
            $site_header = Section::getTemplate('SiteHeader');
            $site_footer = Section::getTemplate('SiteFooter');
            $site_proposal_modal = Section::getTemplate('ProposalModal');
            $slider_banner = Section::getTemplate('SliderBanner');
            $section_heading = Section::getTemplate('SectionHeading');
            $box_callouts = Section::getTemplate('BoxCallouts');
            $our_proccess = Section::getTemplate('OurProcess');
            $meet_our_team = Section::getTemplate('MeetOurTeam');
            $social_stream = Section::getTemplate('SocialStream');
            $customer_testimonials = Section::getTemplate('CustomerTestimonials');
            $thick_page_banner = Section::getTemplate('ThickPageBanner');
            $white_break_w_section_links = Section::getTemplate('WhiteBreakCalloutSectionLinks');
            $provided_solution = Section::getTemplate('ProvidedSolution');
            $blue_break_callout = Section::getTemplate('BlueBreakCallout');
            $breadcrumb_with_right_link = Section::getTemplate('BreadCrumbRightSideLink');
            $process_timeline = Section::getTemplate('ProcessTimeline');
            $process_maintenance_details = Section::getTemplate('MaintenanceDetails');
            $project_list = Section::getTemplate('ProjectList');
            $more_clients_list = Section::getTemplate('MoreClientsList');
            $contact_form = Section::getTemplate('ContactUs');
            $map_address = Section::getTemplate('MapAddress');
            $login_form = Section::getTemplate('CustomerLogin');
            $block_text = Section::getTemplate('BlockText');

            // set the website storage name.
            $wsb->setStorage('plus3website');

            $site = $wsb->getWebsite();
            $publishFrom = realpath(__DIR__.'/../../Public');

            $wsb
                ->setHeader($site_header->id)
                ->setFooter($site_footer->id)
                ->setMetaData([
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                    'custom_header_html' => '',
                    'custom_before_body_end_html' => '',
                    'custom_footer_html' => '',
                    'robots_txt' => '',
                    'facebook_url' => 'https://www.facebook.com/Plus3Interactive/',
                    'instagram_url' => 'https://www.instagram.com/plus3interactive',
                    'twitter_url' => 'https://twitter.com/plus3in',
                    'google_plus_url' => 'https://plus.google.com/+Plus3InteractiveLLCCambridge',
                    'linkedin_url' => 'https://www.linkedin.com/company/1038875',
                ])
                ->SetPublishFrom($publishFrom)
                //@TODO: this can prob just be a stub now.
                ->setLayout('public', '
<template lang="pug">
  <!--[if lt IE 8]>
    p.browserupgrade You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
  <![endif]-->
  <nuxt/>
</template>

<script>
  export default {}
</script>
')
                ->setLayout('error', '
<template lang="pug">
  div
    div.wrapper
      header.header
      main.main
        section.section-module.section-solutions
          .row
            .medium-8.medium-centered.columns
              .section-header
                h2.section-heading {{ error.statusCode }}
                .section-desc
                p {{error.message}}
                nuxt-link.button(to="/", v-if="error.statusCode ===404")
                  | Go to Home Page
</template>
<script>
  export default {
    props: [\'error\']
  }
</script>
')
                ->setDeploymentNpmPackages([
                    'name' => 'Plus3Website',
                    'version' => '3.0.0',
                    'description' => 'P3CMS',
                    'author' => 'Jubair Saidi <jubair.saidi@p3in.com>',
                    'private' => true,
                    'dependencies' => [
                        'nuxt' => 'latest',
                        'axios' => '^0.15.3'
                    ],
                    'devDependencies' => [
                        'pug' => '^2.0.0-beta9',
                        'imports-loader' => '^0.7.0',
                        'jsdom' => '^9.9.1',
                        'node-sass' => '^4.3.0',
                        'sass-loader' => '^4.1.1',
                        'webpack' => '^2.2.0'
                    ],
                    'scripts' => [
                        'dev' => 'nuxt',
                        'build' => 'nuxt build',
                        'start' => 'nuxt start',
                        'generate' => 'nuxt generate'
                    ]
                ])
                // we should prob break this down into pieces.
                ->setDeploymentNuxtConfig([
                    'head' => [
                        'titleTemplate' => '%s - Plus 3 Interactive',
                        'script' => [
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js'],
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'],
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js'],
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'],
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js'],
                            ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.4.1/snap.svg-min.js'],
                        ],
                        'link' => [
                            ['rel' => 'stylesheet', 'href' => 'https://fast.fonts.net/cssapi/e1ef451d-c61f-4ad3-b4e0-e3d8adb46d89.css']
                        ],
                        'meta' => [
                            ['charset' => 'utf-8'],
                            ['http-equiv' => 'x-ua-compatible', 'content' => 'ie=edge'],
                            ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'],
                            ['hid' => 'description', 'content' => 'Plus 3 Interactive, LLC']
                        ],
                        'link' => [
                            ['rel' => 'icon', 'type' => 'image/png', 'href' => '/favicon.png']
                        ]
                    ],
                    'css' => [
                        ['src' => '~assets/sass/main.scss', 'lang' => 'sass']
                    ],
                    'build' => [
                        // 'analyze' => [
                        //   'analyzerMode' => 'static',
                        //   'reportFilename' => 'report.html',
                        //   'generateStatsFile' => true
                        // ],
                        'filenames' => [
                            'css' => 'app.css',
                            'vendor' => 'vendor.js',
                            'app' => 'app.js'
                        ],
                        'vendor' => [
                            'axios'
                        ]
                    ],
                    'plugins' => [
                        '~plugins/ga.js',
                        '~plugins/fb.js',
                        '~plugins/main.js'
                    ],
                    'loading' => [
                        'height' => '3px',
                        'color' => '#0ab7f9'
                    ]
                ]);

            // Build Pages
            $homepage = $wsb
                ->addPage('Home Page', '')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('1.0')
                ->updatedFrequency('always');

            $solutions = $wsb
                ->addPage('Solutions', 'solutions')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.9')
                ->updatedFrequency('yearly');

            $process = $solutions
                ->addChild('Our Process', 'our-process')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.8')
                ->updatedFrequency('yearly');

            $projects = $wsb
                ->addPage('Projects', 'projects')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.9')
                ->updatedFrequency('monthly');

            $company = $wsb
                ->addPage('Company', 'company')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.8')
                ->updatedFrequency('monthly');

            $contact = $wsb
                ->addPage('Contact Us', 'contact')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.7')
                ->updatedFrequency('yearly');

            $login = $wsb
                ->addPage('Customer Login', 'customer-login')
                ->author('Aisha Saidi')
                ->description('This is where we would put the Plus 3 Interactive description')
                ->priority('0.6')
                ->updatedFrequency('never');

            $terms_of_service = $wsb
                ->addPage('Terms of Service', 'terms-of-service')
                ->author('Jubair Saidi')
                ->description('Plus 3 Interactive\'s Terms of Service')
                ->priority('0.5')
                ->updatedFrequency('yearly');

            $privacy_policy = $wsb
                ->addPage('Privacy Policy', 'privacy-policy')
                ->author('Jubair Saidi')
                ->description('Plus 3 Interactive\'s Privacy Policy')
                ->priority('0.5')
                ->updatedFrequency('yearly');

            $getPageContent = function($file, $path)
            {
                $config = require(__DIR__."/content/{$file}.php");
                return array_get($config, $path);
            };


            // header and footer are same on every page site wide.
            $createHeaderFooterStructure = function ($page) use ($site_header, $site_footer, $site_proposal_modal, $getPageContent) {
                $page_container = $page
                    ->addContainer()->order(1)
                        ->addContainer()
                            ->order(1)
                            ->config('class', 'wrapper')
                            ->addSection($site_header)
                                ->order(1)
                                ->props([
                                    'menus' => 'menus',
                                    'meta' => 'site_meta',
                                    'current_url' => 'current_url',
                                ])
                        ->parent()
                            ->addContainer()
                                ->order(2)
                                ->config('elm', 'main')
                                ->config('class', 'main')
                            ->cloneTo($main_container)
                        ->parent()
                            ->addSection($site_footer)
                                ->order(3)
                                ->props([
                                    'menus' => 'menus',
                                    'meta' => 'site_meta',
                                    'current_url' => 'current_url',
                                ])
                    ->parent(2)
                        ->addSection($site_proposal_modal)
                            ->order(2)
                            ->content($getPageContent('global', 'site_proposal_modal'));

                return $main_container;
            };

            // Home Page Layout and Content
            $createHeaderFooterStructure($homepage)
                ->addSection($slider_banner)
                    ->order(1)
                    ->content($getPageContent('homepage', 'slider_banner'))
            ->parent()
                ->addContainer()
                    ->order(2)
                    ->config('elm', 'section')
                    ->config('class', 'section-module section-solutions')
                    ->addSection($section_heading)
                        ->order(1)
                        ->content($getPageContent('homepage', 'section_heading'))
                    ->addContainer()
                        ->order(2)
                        ->config('class', 'row')
                        ->addContainer()
                            ->order(1)
                            ->config('class', 'medium-6 columns')
                            ->addContainer()
                                ->order(1)
                                ->config('class', 'row')
                                ->addSection($box_callouts)
                                    ->order(1)
                                    ->content($getPageContent('homepage', 'box_callouts_1'))
                    ->parent(3)
                        ->addContainer()
                            ->order(2)
                            ->config('class', 'medium-6 columns')
                            ->addContainer()
                                ->order(1)
                                ->config('class', 'row')
                                ->addSection($box_callouts)
                                    ->order(1)
                                    ->content($getPageContent('homepage', 'box_callouts_2'))
            ->parent(5)
                ->addSection($our_proccess)
                    ->order(3)
                    ->content($getPageContent('homepage', 'our_proccess'))
                ->addSection($meet_our_team)
                    ->order(4)
                    ->content($getPageContent('homepage', 'meet_our_team'))
                    ->dynamic(Plus3Person::class, function(FieldSource $source) {
                        $source->relatesTo('team')
                            ->where('public', true)
                            ->sort('id', 'ASC');
                    })
            ->parent()
                ->addSection($social_stream)
                    ->order(5)
                    ->content($getPageContent('homepage', 'social_stream'))
            ->parent()
                ->addSection($customer_testimonials)
                    ->order(6)
                    ->content($getPageContent('homepage', 'customer_testimonials'));


            // Solutions Page Layout and Content
            $createHeaderFooterStructure($solutions)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('solutions', 'thick_page_banner'))
                ->addSection($white_break_w_section_links)
                    ->order(2)
                    ->content($getPageContent('solutions', 'white_break_w_section_links'))
                ->addSection($provided_solution)
                    ->order(3)
                    ->content($getPageContent('solutions', 'provided_solution'))
                ->addSection($blue_break_callout)
                    ->order(4)
                    ->content($getPageContent('solutions', 'blue_break_callout'));


            // Process Page Layout and Content
            $createHeaderFooterStructure($process)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('process', 'thick_page_banner'))
                ->addSection($breadcrumb_with_right_link)
                    ->order(2)
                    ->content($getPageContent('process', 'breadcrumb_with_right_link'))
                ->addSection($white_break_w_section_links)
                    ->order(3)
                    ->content($getPageContent('process', 'white_break_w_section_links'))
            ->parent()
                ->addContainer()
                    ->order(4)
                    ->config('class', 'row')
                    ->addContainer()
                        ->order(1)
                        ->config('class', 'xsmall-12 columns')
                        ->addSection($process_timeline)
                            ->order(1)
                            ->content($getPageContent('process', 'process_timeline'))
            ->parent(3)
                ->addSection($process_maintenance_details)
                    ->order(4)
                    ->content($getPageContent('process', 'process_maintenance_details'));

            // Projects Page Layout and Content
            $projects_container = $createHeaderFooterStructure($projects)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('projects', 'thick_page_banner'))
                ->addSection($white_break_w_section_links)
                    ->order(2)
                    ->content($getPageContent('projects', 'thick_page_banner'))
                ->addSection($project_list)
                    ->order(3)
                    ->content($getPageContent('projects', 'thick_page_banner'))
                ->addContainer()
                    ->order(4)
                    ->config('elm', 'section')
                    ->config('class', 'section-module section-clients')
                    ->addSection($section_heading, 1, [
                        'content' => [
                        ]
                    ])
                    ->addContainer()
                        ->order(2)
                        ->config('class', 'row')
                        ->addContainer()
                            ->order(1)
                            ->config('class', 'medium-9 medium-centered columns')
                            ->addContainer()
                                ->order(1)
                                ->config('class', 'row')
                                ->addSection($more_clients_list)
                                    ->order(1)
                                    ->content($getPageContent('projects', 'more_clients_list'))
            ->parent(5)
                ->addSection($white_break_w_section_links)
                    ->order(5)
                    ->content($getPageContent('projects', 'white_break_w_section_links'))
                ->addSection($blue_break_callout)
                    ->order(6)
                    ->content($getPageContent('projects', 'blue_break_callout'));


            // Company Page Layout and Content
            $company_container = $createHeaderFooterStructure($company)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('company', 'thick_page_banner'))
                ->addSection($meet_our_team)
                    ->order(2)
                    ->content($getPageContent('company', 'meet_our_team'))
                    ->dynamic(Plus3Person::class, function(FieldSource $source) {
                        $source->relatesTo('team')
                            ->where('public', true)
                            ->sort('id', 'ASC');
                    })
                ->addSection($social_stream)
                    ->order(3)
                    ->content($getPageContent('company', 'social_stream'));


            // Contact Us Page Layout and Content
            $contact_container = $createHeaderFooterStructure($contact)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('contact', 'thick_page_banner'))
                ->addSection($contact_form)
                    ->order(2)
                    ->content($getPageContent('contact', 'contact_form'))
                ->addSection($map_address)
                    ->order(3)
                    ->content($getPageContent('contact', 'map_address'));

            // Login Page Layout and Content
            $login_container = $createHeaderFooterStructure($login)
                ->addSection($thick_page_banner)
                    ->order(1)
                    ->content($getPageContent('login', 'thick_page_banner'))
                ->addSection($login_form)
                    ->order(2)
                    ->content($getPageContent('login', 'login_form'));



            // Terms of Service Page Layout and Content
            $terms_of_service_container = $createHeaderFooterStructure($terms_of_service)
                ->addSection($block_text)
                    ->order(1)
                    ->content($getPageContent('terms_of_service', 'block_text'));

            // Privacy Policy Page Layout and Content
            $privacy_policy_container = $createHeaderFooterStructure($privacy_policy)
                ->addSection($block_text)
                    ->order(1)
                    ->content($getPageContent('privacy_policy', 'block_text'));

            // lets compile all the page templates
            // Note that we always want to do this last to account for any pages
            // that have children as they get generated a bit differently than normal pages.
            $homepage->renderTemplate('public');
            $solutions->renderTemplate('public');
            $process->renderTemplate('public');
            $projects->renderTemplate('public');
            $company->renderTemplate('public');
            $contact->renderTemplate('public');
            $login->renderTemplate('public');
            $terms_of_service->renderTemplate('public');
            $privacy_policy->renderTemplate('public');


            // Create the nav menus and add the items.
            $wsb->addMenu('main_header_menu')
                ->add($solutions, 1)->icon('icon-solutions')->sub()
                    ->add($process, 1)->icon('icon-solutions')
                    ->parent()
                ->add($projects, 2)->icon('icon-company')
                ->add($company, 3)->icon('icon-company')
                ->add($contact, 4)->icon('icon-contact')
                ->add($login, 5)->icon('icon-login')
                ;

            $wsb->addMenu('main_footer_menu')
                ->add($solutions, 1)
                ->add($process, 2)
                ->add($projects, 3)
                ->add($company, 4)
                ->add($contact, 5)
                ->add($login, 6)
                ->add($terms_of_service, 7)
                ->add($privacy_policy, 8)
                ;

            $wsb->deploy();
        })->getWebsite();

    }
}
