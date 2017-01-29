<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Plus3Person;
use P3in\Models\Section;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\Renderers\PageRenderer;

class Plus3websiteModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE plus3_people RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE users RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE sections RESTART IDENTITY CASCADE');

        // Imene
        $imene = User::create([
            'first_name' => 'Imene',
            'last_name' => 'Saidi',
            'email' => 'imene.saidi@p3in.com',
            'phone' => '617-470-6003',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Co-Founder and CEO',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'imene\'s Bio',
            'instagram' => 'imenebsaidi',
            'twitter' => 'imenesaidi',
            'facebook' => 'Imene.Saidi',
            'linkedin' => 'imenesaidi',
        ]))
            ->user()
            ->associate($imene)
            ->save();

        // Jubair
        $jubair = User::create([
            'first_name' => 'Jubair',
            'last_name' => 'Saidi',
            'email' => 'jubair.saidi@p3in.com',
            'phone' => '617-755-7012',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Co-Founder and CTO',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Jubair\'s Bio',
            'instagram' => 'jubairsaidi',
            'twitter' => 'jubairsaidi',
            'facebook' => 'jubairsaidi',
            'linkedin' => 'jsaidi',
        ]))
            ->user()
            ->associate($jubair)
            ->save();

        // Aisha
        $aisha = User::create([
            'first_name' => 'Aisha',
            'last_name' => 'Saidi',
            'email' => 'aisha.saidi@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Information Architect',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'aisha\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($aisha)
            ->save();

        // Federico
        $federico = User::create([
            'first_name' => 'Federico',
            'last_name' => 'Francescato',
            'email' => 'federico@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Application Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'federico\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($federico)
            ->save();

        // Lazarus
        $lazarus = User::create([
            'first_name' => 'Lazarus',
            'last_name' => 'Morrison',
            'email' => 'lazarus@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'lazarus\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($lazarus)
            ->save();

        // Website Builder API Design

        // field type ->link() allows the admin to select page || select link || create new link.
        // field validation should match exactly: https://laravel.com/docs/5.3/validation#available-validation-rules

        DB::table('websites')->where('host', 'www.plus3interactive.com')->delete();
        DB::table('forms')->whereIn('name', [
            'SiteHeader',
            'SiteFooter',
            'ProposalModal',
            'SliderBanner',
            'SectionHeading',
            'BoxCallouts',
            'OurProcess',
            'MeetOurTeam',
            'SocialStream',
            'CustomerTestimonials',
            'ThickPageBanner',
            'WhiteBreakCalloutSectionLinks',
            'ProvidedSolution',
            'BlueBreakCallout',
            'BreadCrumbRightSideLink',
            'ProcessTimeline',
            'MaintenanceDetails',
            'ProjectList',
            'MoreClientsList',
            'ContactUs',
            'MapAddress',
            'CustomerLogin',
        ])->delete();

        $website = WebsiteBuilder::new('Plus 3 Interactive, LLC', 'https', 'www.plus3interactive.com', function ($wsb) {
            $site = $wsb->getWebsite();
            $deployTo = realpath(App::make('path.websites')).'/'.strtolower(str_slug($site->host));
            $publishFrom = realpath(__DIR__.'/../../Public');

            $wsb
                ->setHeader('SiteHeader') //@TODO: may not be needed here anymore
                ->setFooter('SiteFooter') //@TODO: may not be needed here anymore
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
                ->setDeploymentDisk('local')
                ->setDeploymentPath($deployTo)
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
                        'analyze' => [
                          'analyzerMode' => 'static',
                          'reportFilename' => 'report.html',
                          'generateStatsFile' => true
                        ],
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
                        '~plugins/main.js'
                    ],
                    'loading' => [
                        'height' => '3px',
                        'color' => '#0ab7f9'
                    ]
                ]);
            // Build the components.

            // @TODO: Unless I am missing something, we now have to set the
            // global elements on the pages them selves because of the way the route
            // doesn't hit the layout file (hell not much hits that thing it seems!)
            // so doing logic there is tough (like fetching and injecting menus)
            $site_header = Section::create([
                'name' => 'Site Header',
                'template' => 'SiteHeader',
                'type' => 'header'
            ]);
            $site_footer = Section::create([
                'name' => 'Site Footer',
                'template' => 'SiteFooter',
                'type' => 'footer'
            ]);
            $site_proposal_modal = Section::create([
                'name' => 'Proposal Modal',
                'template' => 'ProposalModal',
                'type' => 'section'
            ]);

            // This one should prob be build with websites module load.
            Section::create([
                'name' => 'Container',
                'template' => 'container', //@TODO: not sure about this, do containers need templates? I feel there are good arguments for both yes and no.
                'type' => 'container',
            ]);

            $slider_banner = Section::create([
                'name' => 'Slider Banner',
                'template' => 'SliderBanner',
                'type' => 'section'
            ]);

            FormBuilder::new('SliderBanner', function ($fb) {
                // we need to figure out how to handle the 'type' field.
                // the fields internally are created in the order they appear in the builder.
                $fb->string('Title', 'title', ['required']);
                $fb->fieldset('Slides', 'slides', [], function ($slide) {
                    // not field type, sub section builder.
                    $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->string('Title', 'title', ['required']);
                    $slide->wysiwyg('Description', 'description', ['required']);
                    $slide->string('Link Text', 'link_text', ['required']);
                    $slide->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            })->setOwner($slider_banner);

            $section_heading = Section::create([
                'name' => 'Section Heading',
                'template' => 'SectionHeading',
                'type' => 'section'
            ]);

            FormBuilder::new('SectionHeading', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
            })->setOwner($section_heading);

            $box_callouts = Section::create([
                'name' => 'Box Callouts',
                'template' => 'BoxCallouts',
                'type' => 'section'
            ]);

            FormBuilder::new('BoxCallouts', function ($fb) {
                $fb->fieldset('Boxes', 'boxes', [], function ($box) {
                    $box->string('Title', 'title', ['required']);
                    $box->file('Image', 'image', Photo::class, ['required']);
                    $box->string('Points', 'points', [])->repeatable();
                    $box->string('Link Text', 'link_text', ['required']);
                    $box->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            })->setOwner($box_callouts);

            $our_proccess = Section::create([
                'name' => 'Our Process',
                'template' => 'OurProcess',
                'type' => 'section'
            ]);

            FormBuilder::new('OurProcess', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
                $fb->string('Link Text', 'link_text', ['required']);
                $fb->link('Link Destination', 'link_href', ['required']);
                // SVG Animation is static, editable in code only.
            })->setOwner($our_proccess);

            $meet_our_team = Section::create([
                'name' => 'Meet Our Team',
                'template' => 'MeetOurTeam',
                'type' => 'section'
            ]);

            FormBuilder::new('MeetOurTeam', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
                $fb->string('Link Text', 'link_text', ['required']);
                $fb->link('Link Destination', 'link_href', ['required']);
            })->setOwner($meet_our_team)
            // ->dynamic(Plus3Person::class) // we need to decide if the section is dynamic, or the field (or both can be)
            ;

            $social_stream = Section::create([
                'name' => 'Social Stream',
                'template' => 'SocialStream',
                'type' => 'section'
            ]);

            FormBuilder::new('SocialStream', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                // Fields
            })->setOwner($social_stream);

            $customer_testimonials = Section::create([
                'name' => 'Customer Testimonials',
                'template' => 'CustomerTestimonials',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerTestimonials', function ($fb) {
                $fb->fieldset('Testimonials', 'testimonials', [], function ($testimonial) {
                    $testimonial->string('Author', 'author', ['required'])->required();
                    $testimonial->wysiwyg('Content', 'content', ['required'])->required();

                    //BEGIN DUMMY: these below are a dummy set to test nesting fieldsets.
                    $testimonial->fieldset('Testimonials', 'testimonials', [], function ($lvl3) {
                        $lvl3->string('Author', 'author', ['required']);
                        $lvl3->wysiwyg('Content', 'content', ['required']);
                        $lvl3->fieldset('Testimonials', 'testimonials', [], function ($lvl4) {
                            $lvl4->string('Author', 'author', ['required']);
                            $lvl4->wysiwyg('Content', 'content', ['required']);
                        })->repeatable();
                    })->repeatable();
                    // END DUMMY:
                })->repeatable();
            })->setOwner($customer_testimonials);

            $thick_page_banner = Section::create([
                'name' => 'Thick Page Banner',
                'template' => 'ThickPageBanner',
                'type' => 'section'
            ]);

            FormBuilder::new('ThickPageBanner', function ($fb) {
                $fb->file('Background Image', 'background_image', []);
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
            })->setOwner($thick_page_banner);

            $white_break_w_section_links = Section::create([
                'name' => 'White Break Callout Section Links',
                'template' => 'WhiteBreakCalloutSectionLinks',
                'type' => 'section'
            ]);

            FormBuilder::new('WhiteBreakCalloutSectionLinks', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
                $fb->fieldset('Page Section Quick Links', 'quick_links', [], function ($quickLinks) {
                    $quickLinks->radio('Link Format', 'link_format', [
                        'ol' => 'Ordered List',
                        'ul' => 'Un Ordered List',
                        'arrow' => 'Link with Arrow',
                    ])->required();
                    $quickLinks->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                });
            })->setOwner($white_break_w_section_links);

            $provided_solution = Section::create([
                'name' => 'Provided Solution',
                'template' => 'ProvidedSolution',
                'type' => 'section'
            ]);

            FormBuilder::new('ProvidedSolution', function ($fb) {
                $fb->fieldset('Solution', 'solution', [], function ($solution) {
                    $solution->radio('Layout', 'layout', ['left' => 'Left', 'right' => 'Right'])->required();
                    $solution->string('Title', 'title', ['required']);
                    $solution->file('Solution Photo', 'solution_photo', []);
                    $solution->wysiwyg('Description', 'description', ['required'])->required();
                    $solution->pageSectionSelect('Projects Using Solution', 'projects_using_solution', [])->repeatable();
                    $solution->text('Link Description', 'link_description', [])->required();
                    $solution->string('Link Title', 'link_title', [])->required();
                    $solution->link('Link Destination', 'link_href', [])->required();
                })->repeatable();
            })->setOwner($provided_solution);

            $blue_break_callout = Section::create([
                'name' => 'Blue Break Callout',
                'template' => 'BlueBreakCallout',
                'type' => 'section'
            ]);

            FormBuilder::new('BlueBreakCallout', function ($fb) {
                $fb->string('Link Title', 'link_title', [])->required();
                $fb->link('Link Destination', 'link_href', [])->required();
            })->setOwner($blue_break_callout);

            $breadcrumb_with_right_link = Section::create([
                'name' => 'BreadCrumb With Right Side Link',
                'template' => 'BreadCrumbRightSideLink',
                'type' => 'section'
            ]);

            FormBuilder::new('BreadCrumbRightSideLink', function ($fb) {
                $fb->string('Link Title', 'link_title', [])->required();
                $fb->link('Link Destination', 'link_href', [])->required();
            })->setOwner($breadcrumb_with_right_link);

            $process_timeline = Section::create([
                'name' => 'Process Timeline',
                'template' => 'ProcessTimeline',
                'type' => 'section'
            ]);

            FormBuilder::new('ProcessTimeline', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
                $fb->fieldset('Process Steps', 'process_steps', [], function ($process) {
                    $process->file('Image File', 'image', ['type:svg']);
                    $process->string('Image width', 'image_width', []);
                    $process->string('Image Height', 'image_height', []);
                    $process->string('Title', 'title', ['required']);
                    $process->wysiwyg('Description', 'description', ['required']);
                })->repeatable();
            })->setOwner($process_timeline);

            $process_maintenance_details = Section::create([
                'name' => 'Maintenance Details',
                'template' => 'MaintenanceDetails',
                'type' => 'section'
            ]);

            FormBuilder::new('MaintenanceDetails', function ($fb) {
                $fb->string('Title', 'title', ['required']);
                $fb->wysiwyg('Description', 'description', ['required']);
                $fb->file('Image File', 'image', ['type:svg']);
                $fb->string('Image width', 'image_width', []);
                $fb->string('Image Height', 'image_height', []);
                $fb->string('Link Title', 'link_title', [])->required();
                $fb->link('Link Destination', 'link_href', [])->required();
            })->setOwner($process_maintenance_details);

            $project_list = Section::create([
                'name' => 'Project List',
                'template' => 'ProjectList',
                'type' => 'section'
            ]);

            FormBuilder::new('ProjectList', function ($fb) {
                $fb->fieldset('Projects', 'projects', [], function ($project) {
                    $project->file('Background Image', 'background_image', ['required']);
                    $project->file('Logo', 'logo', ['required']);
                    $project->string('Name', 'name', ['required']);
                    $project->string('Business Area', 'business_area', ['required']);
                    $project->wysiwyg('Description', 'description', ['required']);
                    $project->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                })->repeatable();
            })->setOwner($project_list);

            $more_clients_list = Section::create([
                'name' => 'More Clients List',
                'template' => 'MoreClientsList',
                'type' => 'section'
            ]);

            FormBuilder::new('MoreClientsList', function ($fb) {
                $fb->fieldset('Clients', 'clients', [], function ($project) {
                    $project->file('Logo', 'logo', ['required']);
                    $project->string('Name', 'name', ['required']);
                    $project->string('Business Area', 'business_area', ['required']);
                    $project->wysiwyg('Description', 'description', ['required']);
                })->repeatable();
            })->setOwner($more_clients_list);

            $contact_form = Section::create([
                'name' => 'Contact Us',
                'template' => 'ContactUs',
                'type' => 'section'
            ]);

            FormBuilder::new('ContactUs', function ($fb) {
                $fb->formBuilder('Contact Form', 'contact_form', []);
            })->setOwner($contact_form);

            $map_address = Section::create([
                'name' => 'Map Address',
                'template' => 'MapAddress',
                'type' => 'section'
            ]);

            FormBuilder::new('MapAddress', function ($fb) {
                $fb->string('Title', 'title', []);
                $fb->string('Phone Number', 'phone', []);
                $fb->string('Address Line 1', 'address_1', []);
                $fb->string('Address Line 2', 'address_2', []);
                $fb->string('City', 'city', []);
                $fb->string('State', 'state', []);
                $fb->string('Zip', 'zip', []);
                $fb->map('Map', 'map', ['address_1', 'address_2', 'city', 'state', 'zip']);
            })->setOwner($map_address);

            // We might want to consider having this section be dynamic rather than set a field to be the dynamic piece?
            // Fields: Email, Password, Remember Me
            // Links: Forgot Password
            $login_form = Section::create([
                'name' => 'Customer Login',
                'template' => 'CustomerLogin',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerLogin', function ($fb) {
                $fb->loginForm('Customer Login', 'customer_login', []);
            })->setOwner($login_form);

            // we should always (but only(?)) have one container component.
            // prob something we seed when loading websites module.


            // header and footer are same on every page site wide.
            $createHeaderFooterStructure = function($page) use ($site_header, $site_footer, $site_proposal_modal) {

                $page_container = $page
                    ->addContainer(1);

                    $wrapper_container = $page_container->addContainer(1, [
                        'class' => 'wrapper',
                    ]);
                    $wrapper_container->addSection($site_header, 1, [
                        // @TODO: meh...
                        'config' => [
                            'props' => [
                                'menus' => 'menus',
                                'meta' => 'site_meta',
                                'current_url' => 'current_url',
                            ]
                        ]
                    ]);

                    $main_container = $wrapper_container->addContainer(2, [
                        'elm' => 'main',
                        'class' => 'main',
                    ]);

                    $wrapper_container->addSection($site_footer, 3, [
                        // @TODO: meh...
                        'config' => [
                            'props' => [
                                'menus' => 'menus',
                                'meta' => 'site_meta',
                                'current_url' => 'current_url',
                            ]
                        ]
                    ]);
                    $page_container->addSection($site_proposal_modal, 2);

                return $main_container;
            };

            // Build Pages
                $homepage = $wsb
                    ->addPage('Home Page', '')
                    ->setAuthor('Aisha Saidi')
                    ->setDescription('This is where we would put the Plus 3 Interactive description')
                    ->setPriority('1.0')
                    ->setUpdatedFrequency('always');

                $home_container = $createHeaderFooterStructure($homepage)
                    ->addSection($slider_banner, 1, [
                        'content' => [
                            'title' => 'Our Work',
                            'slides' => [
                                [
                                    'banner_image' => '/assets/images/content/bg_project_atmgurus.jpg',
                                    'title' => 'ATM Gurus',
                                    'description' => '<p>We developed a flexible, modern eCommerce platform for ATM Gurus and integrated it with the client’s Oracle based ERP and CRM.</p>',
                                    'link_text' => 'See More',
                                    'link_href' => '/projects#atm-gurus', //@TODO: this is a string right now but we need to make this a dynamic object.
                                ],[
                                    'banner_image' => '/assets/images/content/bg_project_bostonpads.jpg',
                                    'title' => 'Boston Pads',
                                    'description' => '<p>For Boston Pads we implemented our content management system for creation and management of multiple real estate Web sites.</p>',
                                    'link_text' => 'See More',
                                    'link_href' => '/projects#boston-pads',
                                ],[
                                    'banner_image' => '/assets/images/content/bg_project_pronto.jpg',
                                    'title' => 'Pronto',
                                    'description' => '<p>We built an expandable prototype for Equinox02 to manage all medical device inventory and delivery services via computer or smart phone.</p>',
                                    'link_text' => 'See More',
                                    'link_href' => '/projects#pronto',
                                ]
                            ]
                        ]
                    ]);

            $home_box_callout_container = $home_container
                ->addContainer(2,[
                    'elm' => 'section',
                    'class' => 'section-module section-solutions',
                ])
                ->addSection($section_heading, 1, [
                    'content' => [
                        'title' => 'Targeted Web Solutions',
                        'description' => '<p>Plus 3 Interactive develops custom web applications that meet the unique needs of your business. We can help your company meet its strategic goals:</p>',
                    ]
                ])
                ->addContainer(2, [
                     'class' => 'row',
                ]);

            $home_box_callout_container
                ->addContainer(1, [
                     'class' => 'medium-6 columns',
                ])
                ->addContainer(1, [
                     'class' => 'row',
                ])
                ->addSection($box_callouts, 1, [
                    'content' => [
                        'boxes' => [
                            [
                                'title' => 'Custom Web Applications',
                                'image' => '/assets/images/content/solution_web_apps.svg',
                                'image_width' => 164,
                                'image_height' => 130,
                                'points' => [
                                    'Web development tailored to your business',
                                    'Web apps for your operations or customers',
                                    'Onshore Web developers you can talk to',
                                ],
                                'link_text' => 'See More',
                                'link_href' => '/solutions#custom-web-applications',
                            ],[
                                'title' => 'Middleware Development',
                                'image' => '/assets/images/content/solution_middleware.svg',
                                'image_width' => 146,
                                'image_height' => 130,
                                'points' => [
                                    'Middleware designed for your requirements',
                                    'Integrated with legacy & proprietary systems',
                                    'Web 2.0 standards',
                                ],
                                'link_text' => 'See More',
                                'link_href' => '/solutions#middleware-development',
                            ]
                        ]
                    ]
                ]);

            $home_box_callout_container
                ->addContainer(2, [
                     'class' => 'medium-6 columns',
                ])
                ->addContainer(1, [
                     'class' => 'row',
                ])
                ->addSection($box_callouts, 1, [
                    'content' => [
                        'boxes' => [
                            [
                                'title' => 'Device Communications',
                                'image' => '/assets/images/content/solution_device_comm.svg',
                                'image_width' => 132,
                                'image_height' => 130,
                                'points' => [
                                    'Internet of Things for your proprietary devices',
                                    'Monitor and manage devices',
                                    'Banking, medical, vending devices',
                                ],
                                'link_text' => 'See More',
                                'link_href' => '/solutions#device-communications',
                            ],[
                                'title' => 'Web Application Management Systems',
                                'image' => '/assets/images/content/solution_app_management.svg',
                                'image_width' => 170,
                                'image_height' => 130,
                                'points' => [
                                    'Manage multiple web apps & sites',
                                    'Easily modify web page design',
                                    'Customized, modular system',
                                ],
                                'link_text' => 'See More',
                                'link_href' => '/solutions#web-application-management-systems',
                            ]
                        ]
                    ]
                ]);

            $home_container
                ->addSection($our_proccess, 3, [
                    'content' => [
                        'title' => 'Our Process',
                        'description' => '<p>Check the SVG animation! cool isn\'t it?</p>',
                        'link_text' => 'Check out the people who make our company work',
                        'link_href' => '/solutions/our-process',
                    ]
                ])
                ->addSection($meet_our_team, 4, [
                    'content' => [
                        'title' => 'The Team',
                        'description' => '<p>Plus 3 Interactive is a customer-focused business.  Our team finds  the right solutions to our customers’ unique challenges. Check out the people who make our company work.</p>',
                        'link_text' => 'Check out the people who make our company work',
                        'link_href' => '/company#meet-our-team',
                    ]
                ])
                ->addSection($social_stream, 5, [
                    'content' => [
                        'title' => 'Plus 3 Interactive <span class="color-blue">-</span> Active!',
                    ]
                ])
                ->addSection($customer_testimonials, 6, [
                    'content' => [
                        'testimonials' => [
                            [
                                'author' => 'Chris Vallely, Christian Brands',
                                'content' => '<p>After 10 years of selling on the same e-commerce platform, we were in dire need of a new system that would allow us to move our e-commerce business forward. The team at Plus 3 Interactive helped us build out 2 new sites for our most popular brands on ExpressionEngine, integrated our site into our existing ERP, and seamlessly migrated over 45,000 products over to the new sites. The look and feel of the new sites give the customer a much more enjoyable shopping experience. With their help, we are continuing to drive more pageviews with a larger percentage of new customers per month, and overall our customers are spending a longer amount of time per visit.</p><p>Plus 3 Interactive helped us reduce the amount of clicks to each product and streamlined our checkout process from 4-5 pages to a single checkout page, resulting in fewer bounces. We continue to work closely to add new features to our site including custom modules built by the Plus 3 team to meet our specific business goals.</p><p>If there is ever an issue with our sites, the Plus 3 Interactive team will drop everything and get the issue resolved. For example: One afternoon we had an employee performing some maintenance in one of our product categories that accidently deleted the entire product selection off the site. I called over to alert them of the news and within 5 minutes Jubair has a representative at our hosting company restoring a backup from the night before. The site was back up in a matter of minutes. At Christian Brands, we’ve worked with a number of developers and none of them offer that type of service. I’d highly recommend Plus 3 Interactive for any web solution, big or small.</p>',
                            ], [
                                'author' => 'Renato Matos, Partner, Capell Barnett Matalon & Schoenfeld LLP',
                                'content' => '<p>It was a pleasure working with Plus 3 Interactive on redesigning our firm’s website. The developers diligently and successfully implemented our goals in a professional and timely manner. Moreover, Plus 3 continues to seamlessly assist us with continued updates and modifications. We highly recommend Plus 3 and their great staff.</p>',
                            ], [
                                'author' => 'Calvin P. Goetz, Managing Partner, Strategy Financial Group',
                                'content' => '<p>If you are considering a new website project, look no further than Plus 3 Interactive. Their knowledgeable and competent staff helped my company build a fantastic new site with lots of features in a very short period of time. I couldn’t be happier with their work and ongoing support.</p>',
                            ]
                        ]
                    ]
                ]);

            $solutions = $wsb
                ->addPage('Solutions', 'solutions')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.9')
                ->setUpdatedFrequency('yearly');

            $solutions_container = $createHeaderFooterStructure($solutions)
                ->addSection($thick_page_banner, 1)
                ->addSection($white_break_w_section_links, 2)
                ->addSection($provided_solution, 3)
                ->addSection($blue_break_callout, 4);

            $process = $solutions
                ->addChild('Our Process', 'our-process')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.8')
                ->setUpdatedFrequency('yearly');

            $process_container = $createHeaderFooterStructure($process)
                ->addSection($thick_page_banner, 1)
                ->addSection($breadcrumb_with_right_link, 2);

            $process_timeline_section = $process_container
                ->addContainer(3, [
                    'class' => 'row',
                ])
                ->addContainer(1, [
                    'class' => 'xsmall-12 columns',
                ]);

            $process_timeline_section
                ->addSection($process_timeline, 1);

            $process_container
                ->addSection($process_maintenance_details, 3);

            $projects = $wsb
                ->addPage('Projects', 'projects')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.9')
                ->setUpdatedFrequency('monthly');

            $projects_container = $createHeaderFooterStructure($projects)
                ->addSection($thick_page_banner, 1)
                ->addSection($project_list, 2);


            $projects_more_clients_container = $projects_container
                ->addContainer(3, [
                    'elm' => 'section',
                    'class' => 'section-module section-clients',
                ])
                ->addSection($section_heading, 1)
                ->addContainer(2, [
                    'class' => 'row',
                ])
                ->addContainer(1, [
                    'class' => 'medium-9 medium-centered columns',
                ])
                ->addContainer(1, [
                    'class' => 'row',
                ])
                ->addSection($more_clients_list, 1);

            $projects_container
                ->addSection($white_break_w_section_links, 4)
                ->addSection($blue_break_callout, 5);

            $company = $wsb
                ->addPage('Company', 'company')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.8')
                ->setUpdatedFrequency('monthly');

            $company_container = $createHeaderFooterStructure($company)
                ->addSection($thick_page_banner, 1)
                ->addSection($meet_our_team, 2)
                ->addSection($social_stream, 3);

            $contact = $wsb
                ->addPage('Contact Us', 'contact')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.7')
                ->setUpdatedFrequency('yearly');

            $contact_container = $createHeaderFooterStructure($contact)
                ->addSection($thick_page_banner, 1)
                ->addSection($contact_form, 2)
                ->addSection($map_address, 3);

            $login = $wsb
                ->addPage('Customer Login', 'customer-login')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.6')
                ->setUpdatedFrequency('never');

            $login_container = $createHeaderFooterStructure($login)
                ->addSection($thick_page_banner, 1)
                ->addSection($login_form, 2);

            // lets compile all the page templates
            // Note that we always want to do this last to account for any pages
            // that have children as they get generated a bit differently than normal pages.
            $homepage->compilePageTemplate('public');
            $solutions->compilePageTemplate('public');
            $process->compilePageTemplate('public');
            $projects->compilePageTemplate('public');
            $company->compilePageTemplate('public');
            $contact->compilePageTemplate('public');
            $login->compilePageTemplate('public');

            // Create the nav menus and add the items.
            $main_header_menu = $wsb->addMenu('main_header_menu');

            // $main_header_menu->addItem($homepage, 1)->setIcon('icon-home');

            $solutions_item = $main_header_menu->addItem($solutions, 1)->setIcon('icon-solutions');
            $solutions_item->addItem($process, 1)->setIcon('icon-solutions');

            $main_header_menu->addItem($projects, 2)->setIcon('icon-projects');
            $main_header_menu->addItem($company, 3)->setIcon('icon-company');
            $main_header_menu->addItem($contact, 4)->setIcon('icon-contact');
            $main_header_menu->addItem($login, 5)->setIcon('icon-login');

            $main_footer_menu = $wsb->addMenu('main_footer_menu');
            $main_footer_menu->addItem($solutions, 1);
            $main_footer_menu->addItem($process, 2);
            $main_footer_menu->addItem($projects, 3);
            $main_footer_menu->addItem($company, 4);
            $main_footer_menu->addItem($contact, 5);
            $main_footer_menu->addItem($login, 6);

            $wsb->deploy();

        })->getWebsite();


        // // Now lets test the magic!
        // DB::enableQueryLog();
        // $website_for_renderer = Website::find($website->id);
        // $renderer =  new PageRenderer($website_for_renderer);

        // $data = $renderer->setPage('/solutions/our-process')->render(); // edit() for CP, render() for public.

        // dd(DB::getQueryLog(), $data);

/*

 */
    }
}
