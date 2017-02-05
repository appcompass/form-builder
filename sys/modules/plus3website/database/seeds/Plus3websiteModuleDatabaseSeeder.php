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
use P3in\Models\FieldSource;

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
            'title' => 'Co-Founder and Client Relations',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'imene\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_imene.jpg',
            'full_photo' => '/assets/images/content/team_imene_popup.jpg',
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
            'title' => 'Co-Founder and Development Lead',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Jubair\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_jubair.jpg',
            'full_photo' => '/assets/images/content/team_jubair.jpg',
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_aisha.jpg',
            'full_photo' => '/assets/images/content/team_aisha.jpg',
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_federico.jpg',
            'full_photo' => '/assets/images/content/team_federico.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($federico)
            ->save();

        // Michael
        $michael = User::create([
            'first_name' => 'Michael',
            'last_name' => 'Farrell',
            'email' => 'michael@p3in.com',
            'phone' => '',

            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Designer & Front-End Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Michael Farrell\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_michael.jpg',
            'full_photo' => '/assets/images/content/team_michael.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($michael)
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_lazarus.jpg',
            'full_photo' => '/assets/images/content/team_lazarus.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($lazarus)
            ->save();

        // Justin
        $justin = User::create([
            'first_name' => 'Justin',
            'last_name' => 'Varberakis',
            'email' => 'justin@p3in.com',
            'phone' => '',

            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Graphic & Web Designer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Justin\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_justin.jpg',
            'full_photo' => '/assets/images/content/team_justin.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($justin)
            ->save();

        // Mike Duffy
        $mike_duffy = User::create([
            'first_name' => 'Mike',
            'last_name' => 'Duffy',
            'email' => 'mike.duffy@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Michael Duffy\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_duffy.jpg',
            'full_photo' => '/assets/images/content/team_duffy.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($mike_duffy)
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
            'BlockText',
        ])->delete();

        DB::table('field_sources')->whereIn('linked_type', [
            'P3in\Models\Types\DynamicType', //@TODO: we shouldn't be clearing this here like this, need to be more specific
            'P3in\Models\PageSectionContent',
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
                        '~plugins/fb.js',
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

            $form = FormBuilder::new('SliderBanner', function (FormBuilder $fb) {
                // the fields internally are created in the order they appear in the builder.
                $fb->string('Title', 'title')->validation(['required']);

                // fieldset will return a FormBuilder instance with Parent set to current field
                $fb->fieldset('Slides', 'slides', function (FormBuilder $slide) {
                    // not field type, sub section builder.
                    // $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->file('Banner Image', 'banner_image')->validation(['required']);
                    $slide->string('Title', 'title')->validation(['required']);
                    $slide->wysiwyg('Description', 'description')->validation(['required']);
                    $slide->string('Link Text', 'link_text')->validation(['required']);
                    $slide->link('Link Destination', 'link_href')->validation(['required']);
                })->repeatable();
            })->setOwner($slider_banner)
            ->getForm();

            $section_heading = Section::create([
                'name' => 'Section Heading',
                'template' => 'SectionHeading',
                'type' => 'section'
            ]);

            FormBuilder::new('SectionHeading', function (FormBuilder $fb) {
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
            })->setOwner($section_heading);

            $box_callouts = Section::create([
                'name' => 'Box Callouts',
                'template' => 'BoxCallouts',
                'type' => 'section'
            ]);

            FormBuilder::new('BoxCallouts', function (FormBuilder $fb) {
                $fb->fieldset('Boxes', 'boxes', function (FormBuilder $box) {
                    $box->string('Title', 'title')->validation(['required']);
                    $box->file('Image', 'image')->validation(['required']);
                    $box->string('Points', 'points')->repeatable();
                    $box->string('Link Text', 'link_text')->validation(['required']);
                    $box->link('Link Destination', 'link_href')->validation(['required']);
                })->repeatable();
            })->setOwner($box_callouts);

            $our_proccess = Section::create([
                'name' => 'Our Process',
                'template' => 'OurProcess',
                'type' => 'section'
            ]);

            FormBuilder::new('OurProcess', function (FormBuilder $fb) {
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
                $fb->string('Link Text', 'link_text')->validation(['required']);
                $fb->link('Link Destination', 'link_href')->validation(['required']);
                // SVG Animation is static, editable in code only.
            })->setOwner($our_proccess);

            $meet_our_team = Section::create([
                'name' => 'Meet Our Team',
                'template' => 'MeetOurTeam',
                'type' => 'section'
            ]);

            FormBuilder::new('MeetOurTeam', function (FormBuilder $fb) {
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
                $fb->string('Link Text', 'link_text')->validation(['required']);
                $fb->link('Link Destination', 'link_href')->validation(['required']);
                // this will receive a configure_dynamic form
                // dynamic field type // dynamic data for initial setup
                $fb->dynamic('The Team', 'team'); //->dynamic(\P3in\Models\Plus3Person::class, function(FieldSource $source) {
                    // $source->sort('title', 'ASC');
                // });
            })->setOwner($meet_our_team);

            $social_stream = Section::create([
                'name' => 'Social Stream',
                'template' => 'SocialStream',
                'type' => 'section'
            ]);

            FormBuilder::new('SocialStream', function ($fb) {
                $fb->string('Title', 'title')->validation(['required']);
                // Fields
            })->setOwner($social_stream);

            $customer_testimonials = Section::create([
                'name' => 'Customer Testimonials',
                'template' => 'CustomerTestimonials',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerTestimonials', function (FormBuilder $fb) {
                $fb->fieldset('Testimonials', 'testimonials', function (FormBuilder $testimonial) {
                    $testimonial->string('Author', 'author')->validation(['required'])->required();
                    $testimonial->wysiwyg('Content', 'content')->validation(['required'])->required();
                })->repeatable();
            })->setOwner($customer_testimonials);

            $thick_page_banner = Section::create([
                'name' => 'Thick Page Banner',
                'template' => 'ThickPageBanner',
                'type' => 'section'
            ]);

            FormBuilder::new('ThickPageBanner', function (FormBuilder $fb) {
                $fb->file('Background Image', 'background_image');
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
            })->setOwner($thick_page_banner);

            $white_break_w_section_links = Section::create([
                'name' => 'White Break Callout Section Links',
                'template' => 'WhiteBreakCalloutSectionLinks',
                'type' => 'section'
            ]);

            FormBuilder::new('WhiteBreakCalloutSectionLinks', function (FormBuilder $fb) {
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
                // do we really need a fieldset here? fieldsets means the frontend adds a depth to the object, i.e: data.quick_links.format instead of simply data.format
                // $fb->fieldset('Page Section Quick Links', 'quick_links', function (FormBuilder $quickLinks) {
                    $fb->radio('Link Format', 'format')->required(); // @TODO DataSource: ['ol' => 'Ordered List', 'ul' => 'Un Ordered List', 'arrow' => 'Link with Arrow', ]
                    $fb->pageSectionSelect('Page Section Quick Links', 'links')->repeatable();
                // });
            })->setOwner($white_break_w_section_links);

            $provided_solution = Section::create([
                'name' => 'Provided Solution',
                'template' => 'ProvidedSolution',
                'type' => 'section'
            ]);

            FormBuilder::new('ProvidedSolution', function (FormBuilder $fb) {
                $fb->fieldset('Solution', 'solution', function (FormBuilder $solution) {
                    $solution->radio('Layout', 'layout')->required(); // @TODO DataSource , ['left' => 'Left', 'right' => 'Right']
                    $solution->string('Title', 'title')->validation(['required']);
                    $solution->file('Solution Photo', 'solution_photo');
                    $solution->string('Solution Photo Width', 'photo_width');
                    $solution->string('Solution Photo Height', 'photo_height');
                    $solution->wysiwyg('Description', 'description')->validation(['required'])->required();
                    $solution->pageSectionSelect('Projects Using Solution', 'projects_using_solution')->repeatable();
                    $solution->text('Link Description', 'link_description')->required();
                    $solution->string('Link Title', 'link_title')->required();
                    $solution->link('Link Destination', 'link_href')->required();
                })->repeatable();
            })->setOwner($provided_solution);

            $blue_break_callout = Section::create([
                'name' => 'Blue Break Callout',
                'template' => 'BlueBreakCallout',
                'type' => 'section'
            ]);

            FormBuilder::new('BlueBreakCallout', function (FormBuilder $fb) {
                $fb->string('Link Title', 'link_title')->required();
                $fb->link('Link Destination', 'link_href')->required();
            })->setOwner($blue_break_callout);

            $breadcrumb_with_right_link = Section::create([
                'name' => 'BreadCrumb With Right Side Link',
                'template' => 'BreadCrumbRightSideLink',
                'type' => 'section'
            ]);

            FormBuilder::new('BreadCrumbRightSideLink', function (FormBuilder $fb) {
                $fb->string('Link Title', 'link_title')->required();
                $fb->link('Link Destination', 'link_href')->required();
            })->setOwner($breadcrumb_with_right_link);

            $process_timeline = Section::create([
                'name' => 'Process Timeline',
                'template' => 'ProcessTimeline',
                'type' => 'section'
            ]);

            FormBuilder::new('ProcessTimeline', function (FormBuilder $fb) {
                $fb->fieldset('Process Steps', 'process_steps', function (FormBuilder $process) {
                    $process->file('Image File', 'image')->validation(['type:svg']);
                    $process->string('Image width', 'image_width');
                    $process->string('Image Height', 'image_height');
                    $process->string('Title', 'title')->validation(['required']);
                    $process->wysiwyg('Description', 'description')->validation(['required']);
                })->repeatable();
            })->setOwner($process_timeline);

            $process_maintenance_details = Section::create([
                'name' => 'Maintenance Details',
                'template' => 'MaintenanceDetails',
                'type' => 'section'
            ]);

            FormBuilder::new('MaintenanceDetails', function (FormBuilder $fb) {
                $fb->string('Title', 'title')->validation(['required']);
                $fb->wysiwyg('Description', 'description')->validation(['required']);
                $fb->file('Image File', 'image', ['type:svg']);
                $fb->string('Image width', 'image_width');
                $fb->string('Image Height', 'image_height');
                $fb->string('Link Title', 'link_title')->required();
                $fb->link('Link Destination', 'link_href')->required();
            })->setOwner($process_maintenance_details);

            $project_list = Section::create([
                'name' => 'Project List',
                'template' => 'ProjectList',
                'type' => 'section'
            ]);

            FormBuilder::new('ProjectList', function (FormBuilder $fb) {
                $fb->fieldset('Projects', 'projects', function (FormBuilder $project) {
                    $project->file('Background Image', 'background_image')->validation(['required']);
                    $project->file('Logo', 'logo')->validation(['required']);
                    $project->string('Name', 'name')->validation(['required']);
                    $project->string('Business Area', 'business_area')->validation(['required']);
                    $project->wysiwyg('Description', 'description')->validation(['required']);
                    $project->pageSectionSelect('Page Section Quick Links', 'quick_links');
                })->repeatable();
            })->setOwner($project_list);

            $more_clients_list = Section::create([
                'name' => 'More Clients List',
                'template' => 'MoreClientsList',
                'type' => 'section'
            ]);

            FormBuilder::new('MoreClientsList', function (FormBuilder $fb) {
                $fb->fieldset('Clients', 'clients', function (FormBuilder $project) {
                    $project->file('Logo', 'logo')->validation(['required']);
                    $project->string('Name', 'name')->validation(['required']);
                    $project->string('Business Area', 'business_area')->validation(['required']);
                    $project->wysiwyg('Description', 'description')->validation(['required']);
                })->repeatable();
            })->setOwner($more_clients_list);

            $contact_form = Section::create([
                'name' => 'Contact Us',
                'template' => 'ContactUs',
                'type' => 'section'
            ]);

            FormBuilder::new('ContactUs', function (FormBuilder $fb) {
                $fb->formBuilder('Contact Form', 'contact_form');
            })->setOwner($contact_form);

            $map_address = Section::create([
                'name' => 'Map Address',
                'template' => 'MapAddress',
                'type' => 'section'
            ]);

            FormBuilder::new('MapAddress', function (FormBuilder $fb) {
                $fb->string('Title', 'title');
                $fb->string('Phone Number', 'phone');
                $fb->string('Address Line 1', 'address_1');
                $fb->string('Address Line 2', 'address_2');
                $fb->string('City', 'city');
                $fb->string('State', 'state');
                $fb->string('Zip', 'zip');
                $fb->map('Map', 'map'); // @TODO What is this ['address_1', 'address_2', 'city', 'state', 'zip']);
            })->setOwner($map_address);

            // We might want to consider having this section be dynamic rather than set a field to be the dynamic piece?
            // Fields: Email, Password, Remember Me
            // Links: Forgot Password
            $login_form = Section::create([
                'name' => 'Customer Login',
                'template' => 'CustomerLogin',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerLogin', function (FormBuilder $fb) {
                $fb->loginForm('Customer Login', 'customer_login');
            })->setOwner($login_form);


            $block_text = Section::create([
                'name' => 'Block Text',
                'template' => 'BlockText',
                'type' => 'section'
            ]);

            FormBuilder::new('BlockText', function (FormBuilder $fb) {
                $fb->wysiwyg('Content', 'content')->validation(['required']);
            })->setOwner($block_text);

            // we should always (but only(?)) have one container component.
            // prob something we seed when loading websites module.


            // header and footer are same on every page site wide.
            $createHeaderFooterStructure = function ($page) use ($site_header, $site_footer, $site_proposal_modal) {
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
                ->addContainer(2, [
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
                ], true)->dynamic(Plus3Person::class, function(FieldSource $source) {
                    $source->relatesTo('team');
                    $source->sort('id', 'ASC');
                    // $source->limit(3);
                });

            $home_container->addSection($social_stream, 5, [
                    'content' => [
                        'title' => 'Plus 3 Interactive <span class="color-blue">-</span> Active!',
                    ]
                ])
                ->addSection($customer_testimonials, 6, [
                    'content' => [
                        'testimonials' => [
                            [
                                'author' => 'Chris Vallely, Christian Brands',
                                'content' => '<p>Plus 3 Interactive helped us build out 2 new sites for our most popular brands, integrated our existing ERP, and seamlessly migrated over 45,000 products to the new sites.</p>',
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
                ->addSection($thick_page_banner, 1, [
                    'content' => [
                        'background_image' => '',
                        'title' => 'Solutions',
                        'description' => '',
                    ]
                ])
                ->addSection($white_break_w_section_links, 2, [
                    'content' => [
                        'title' => 'Targeted Web Solutions',
                        'description' => '<p>We  find optimal solutions for your unique business challenges, including</p>',
                        'link_format' => 'ul',
                        'links' => [
                            [
                                'text' => 'Web applications for online businesses',
                                'href' => '',
                                //@TODO: Concept.
                                'page_section' => [
                                    'page_id' => 1,
                                    'section_id' => 3
                                ]
                            ], [
                                'text' => 'Middleware for integration of legacy systems',
                                'href' => '',
                                'page_section' => [
                                    'page_id' => 1,
                                    'section_id' => 3
                                ]
                            ], [
                                'text' => 'Software for connected devices',
                                'href' => '',
                                'page_section' => [
                                    'page_id' => 1,
                                    'section_id' => 3
                                ]
                            ], [
                                'text' => 'Customized application management systems',
                                'href' => '',
                                'page_section' => [
                                    'page_id' => 1,
                                    'section_id' => 3
                                ]
                            ],
                        ]
                    ]
                ])
                ->addSection($provided_solution, 3, [
                    'content' => [
                        'solutions' => [
                            [
                                'layout' => 'left',
                                'title' => 'Custom Web Applications',
                                'solution_photo' => '/assets/images/content/custom_web_applications.svg',
                                'photo_width' => 380,
                                'photo_height' => 320,
                                'description' => '<p>Web development is our core competency, with expertise in eCommerce sites, intranet portals, and other Web apps that require custom integration with client systems.</p>
<p>We’ve built Web applications for a range of business needs:
    <ul>
        <li>Streamlining, automating, and tracking client business data and information</li>
        <li>Facilitating networked B2B relationships</li>
        <li>Improving distributor interactions, sales, and maintenance workflows</li>
        <li>Designing remote device networking and management, with increased performance and visibility</li>
    </ul>
</p>',
                                'projects_using_solution' => [],
                                'link_description' => 'Want to know more? Please contact us.',
                                'link_title' => 'Learn More',
                                'link_href' => '',
                            ], [
                                'layout' => 'right',
                                'title' => 'Middleware Development',
                                'solution_photo' => '/assets/images/content/middleware_development.svg',
                                'photo_width' => 362,
                                'photo_height' => 300,
                                'description' => '<p>Are you using legacy CRM or ERP applications that hold you back in the modern Web landscape? We integrate your legacy backend systems with modern web applications.</p>

<p>Our middleware work meets diverse client requirements, such as:
    <ul>
        <li>Integrating multiple sources of data into a modern web application</li>
        <li>Upgrading legacy data architecture to enhance performance</li>
        <li>Real time integration with improved performance and user experience</li>
    </ul>
</p>',
                                'projects_using_solution' => [],
                                'link_description' => 'Need to integrate legacy system with modern apps? Please contact us.',
                                'link_title' => 'Contact Us',
                                'link_href' => '',
                            ], [
                                'layout' => 'left',
                                'title' => 'Device Communications',
                                'solution_photo' => '/assets/images/content/device_communications.svg',
                                'photo_width' => 324,
                                'photo_height' => 290,
                                'description' => '<p>We develop systems for efficient, remote management of numerous commercial devices. These systems are designed for scalability, performance, usability, and security.</p>
<p>We have developed or consulted on such diverse areas as medical devices and banking machines, including:
    <ul>
        <li>Management of device configurations, upgrades, and repairs</li>
        <li>Device monitoring and notifications</li>
        <li>Trending and data analytics on device performance,  users, system resources, and more</li>
    </ul>
</p>',
                                'projects_using_solution' => [],
                                'link_description' => 'Do you want your devices connected? Contact us.',
                                'link_title' => 'Contact Us',
                                'link_href' => '',
                            ], [
                                'layout' => 'right',
                                'title' => 'Modular Application Management System',
                                'solution_photo' => '/assets/images/content/modular_application_management.svg',
                                'photo_width' => 370,
                                'photo_height' => 300,
                                'description' => '<p>To facilitate our clients’ management of their Web applications, we developed a modular application management system (AMS). We customize the AMS so clients may build, modify, and manage one or many Web sites through one system.</p>

<p>Benefits of the system:
    <ul>
        <li>Accessible from range of mobile devices or computer</li>
        <li>Flexible design of Web pages, colors, images, content</li>
        <li>Modifications of Web site easily implemented</li>
        <li>Range of user permissions controlled by administrator</li>
        <li>Bank-level security for eCommerce, banking, or medical sites</li>
        <li>Regular updates of AMS provided by Plus 3 Interactive</li>
    </ul>
</p>',
                                'projects_using_solution' => [],
                                'link_description' => 'Looking for comprehensive app management? Contact us.',
                                'link_title' => 'Contact Us',
                                'link_href' => '',
                            ], [
                                'layout' => 'left',
                                'title' => 'The Development Process',
                                'solution_photo' => '/assets/images/content/development_process.svg',
                                'photo_width' => 324,
                                'photo_height' => 290,
                                'description' => '<p>In big projects and small, Plus 3 Interactive builds value and well-crafted solutions through our defined development process. Before beginning work on a project, we gather information from the client and tailor an end-to-end project plan based on the client’s requirements.</p>

<p>The project plan is a deliverable that we present to the client at the start of the project. It details information architecture, design, and development steps, including schedules, deliverables for each phase, responsibilities, and much more...</p>',
                                'projects_using_solution' => [],
                                'link_description' => 'Learn more about our process.',
                                'link_title' => 'Our Process',
                                'link_href' => '',
                            ],
                        ]
                    ]
                ])
                ->addSection($blue_break_callout, 4, [
                    'content' => [
                        'link_title' => 'Interested in what we can do for you? Please submit an RFP.',
                        'link_href' => ''
                    ]
                ]);


            $process = $solutions
                ->addChild('Our Process', 'our-process')
                ->setAuthor('Aisha Saidi')
                ->setDescription('This is where we would put the Plus 3 Interactive description')
                ->setPriority('0.8')
                ->setUpdatedFrequency('yearly');

            $process_container = $createHeaderFooterStructure($process)
                ->addSection($thick_page_banner, 1, [
                    'content' => [
                        'background_image' => '',
                        'title' => 'Our Process',
                        'description' => '',
                    ]
                ])
                ->addSection($breadcrumb_with_right_link, 2, [
                    'content' => [
                        'link_title' => 'Learn more about Plus 3 Interactive',
                        'link_href' => '',
                    ]
                ])
                ->addSection($white_break_w_section_links, 3, [
                    'content' => [
                        'title' => 'Steps to Software Success',
                        'description' => '<p>From our first meeting with you, through each stage of product development, we follow a clear process to deliver quality and keep you informed.</p>',
                        'link_format' => '',
                        'links' => []
                    ]
                ]);

            $process_timeline_section = $process_container
                ->addContainer(4, [
                    'class' => 'row',
                ])
                ->addContainer(1, [
                    'class' => 'xsmall-12 columns',
                ]);

            $process_timeline_section
                ->addSection($process_timeline, 1, [
                    'content' => [
                        'process_steps' => [
                            [
                                'image' => '/assets/images/content/icon_discovery.svg',
                                'image_width' => 86,
                                'image_height' => 40,
                                'title' => 'Discovery',
                                'description' => '<p>You tell us about your project and we develop a proposal of responsibilities, budget, and timeline.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_client_consultation.svg',
                                'image_width' => 134,
                                'image_height' => 143,
                                'title' => 'Client Consultation',
                                'description' => '<p>From your requirements, users, content, branding, and features, we begin developing the project plan.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_kick_off.svg',
                                'image_width' => 203,
                                'image_height' => 126,
                                'title' => 'Kick Off Meeting',
                                'description' => '<p>We meet with you to discuss the project plan, including timeline, milestones, training, meeting schedule, risk management, and next steps.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_info_architecture.svg',
                                'image_width' => 140,
                                'image_height' => 198,
                                'title' => 'Information Architecture',
                                'description' => '<p>Our information architect analyzes users; develops content outline for web pages;  and creates keywords, navigation, and site map.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_design.svg',
                                'image_width' => 174,
                                'image_height' => 174,
                                'title' => 'Design',
                                'description' => '<p>Our designer provides a complete design consultation; creates wireframes; and implements design of pages and UI components.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_frontend_dev.svg',
                                'image_width' => 210,
                                'image_height' => 132,
                                'title' => 'Front-end Development',
                                'description' => '<p>Upon your approval of the Web design, our front-end developer converts it into a responsive, accessible, and user-friendly Web experience.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_middleware_dev.svg',
                                'image_width' => 210,
                                'image_height' => 132,
                                'title' => 'Back-end & Middleware Development',
                                'description' => '<p>Using modern technologies, our developers plan, build, and test the secure Web application, integrating it with your systems as required.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_quality_assurance.svg',
                                'image_width' => 225,
                                'image_height' => 120,
                                'title' => 'Quality Assurance Testing',
                                'description' => '<p>We implement our standard processes to uncover issues to be corrected and features that require additional development.</p>',
                            ],[
                                'image' => '/assets/images/content/icon_launch.svg',
                                'image_width' => 226,
                                'image_height' => 210,
                                'title' => 'Launch',
                                'description' => '<p>Your Web application goes live! But our role isn’t done yet – we’ll resolve any post-launch bugs and help you plan for future phases of your project.</p>',
                            ]
                        ],
                    ]
                ]);

            $process_container
                ->addSection($process_maintenance_details, 4, [
                    'content' => [
                        'title' => 'What about Maintenance?',
                        'description' => '<p>We take a phased approach to roll out.  After launch of your Web application, we can customize a maintenance plan that could include:
    <ul>
        <li>Ongoing application design or development</li>
        <li>Ongoing content development</li>
        <li>Research and planning consultations</li>
    </ul>
</p>
<p>Please ask us about our maintenance plans.</p>',
                        'image' => '/assets/images/content/icon_maintenance.svg',
                        'image_width' => '152',
                        'image_height' => '152',
                        'link_title' => 'Contact Us',
                        'link_href' => '',
                    ]
                ]);

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


            $terms_of_service = $wsb
                ->addPage('Terms of Service', 'terms-of-service')
                ->setAuthor('Jubair Saidi')
                ->setDescription('Plus 3 Interactive\'s Terms of Service')
                ->setPriority('0.5')
                ->setUpdatedFrequency('yearly');

            $terms_of_service_container = $createHeaderFooterStructure($terms_of_service)
                ->addSection($block_text, 1, [
                    'content' => [
                        'content' => '<h1>Terms of Service</h1>
<p>Last updated: January 31, 2017</p>
<p>Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the https://www.plus3interactive.com website (the "Service") operated by Plus 3 Interactive, LLC ("us", "we", or "our").</p>
<p>Your access to and use of the Service is conditioned upon your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who wish to access or use the Service.</p>
<p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you do not have permission to access the Service.</p>
<p><h2>Accounts</h2></p>
<p>When you create an account with us, you guarantee that you are above the age of 18, and that the information you provide us is accurate, complete, and current at all times. Inaccurate, incomplete, or obsolete information may result in the immediate termination of your account on the Service.</p>
<p>You are responsible for maintaining the confidentiality of your account and password, including but not limited to the restriction of access to your computer and/or account. You agree to accept responsibility for any and all activities or actions that occur under your account and/or password, whether your password is with our Service or a third-party service. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>
<p>You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trademark that is subject to any rights of another person or entity other than you, without appropriate authorization. You may not use as a username any name that is offensive, vulgar or obscene.</p>
<p><h2>Intellectual Property</h2>
The Service and its original content, features and functionality are and will remain the exclusive property of Plus 3 Interactive, LLC and its licensors. The Service is protected by copyright, trademark, and other laws of both the United States and foreign countries. Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of Plus 3 Interactive, LLC.</p>
<p><h2>Links To Other Web Sites</h2></p>
<p>Our Service may contain links to third party web sites or services that are not owned or controlled by Plus 3 Interactive, LLC.</p>
<p>Plus 3 Interactive, LLC has no control over, and assumes no responsibility for the content, privacy policies, or practices of any third party web sites or services. We do not warrant the offerings of any of these entities/individuals or their websites.</p>
<p>You acknowledge and agree that Plus 3 Interactive, LLC shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such third party web sites or services.</p>
<p>We h2ly advise you to read the terms and conditions and privacy policies of any third party web sites or services that you visit.</p>
<p><h2>Termination</h2></p>
<p>We may terminate or suspend your account and bar access to the Service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.</p>
<p>If you wish to terminate your account, you may simply discontinue using the Service.</p>
<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
<p><h2>Indemnification</h2></p>
<p>You agree to defend, indemnify and hold harmless Plus 3 Interactive, LLC and its licensee and licensors, and their employees, contractors, agents, officers and directors, from and against any and all claims, damages, obligations, losses, liabilities, costs or debt, and expenses (including but not limited to attorney\'s fees), resulting from or arising out of a) your use and access of the Service, by you or any person using your account and password, or b) a breach of these Terms.</p>
<p><h2>Limitation Of Liability</h2></p>
<p>In no event shall Plus 3 Interactive, LLC, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your access to or use of or inability to access or use the Service; (ii) any conduct or content of any third party on the Service; (iii) any content obtained from the Service; and (iv) unauthorized access, use or alteration of your transmissions or content, whether based on warranty, contract, tort (including negligence) or any other legal theory, whether or not we have been informed of the possibility of such damage, and even if a remedy set forth herein is found to have failed of its essential purpose.</p>
<p><h2>Disclaimer</h2></p>
<p>Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS AVAILABLE" basis. The Service is provided without warranties of any kind, whether express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, non-infringement or course of performance.</p>
<p>Plus 3 Interactive, LLC its subsidiaries, affiliates, and its licensors do not warrant that a) the Service will function uninterrupted, secure or available at any particular time or location; b) any errors or defects will be corrected; c) the Service is free of viruses or other harmful components; or d) the results of using the Service will meet your requirements.</p>
<p><h2>Exclusions</h2></p>
<p>Some jurisdictions do not allow the exclusion of certain warranties or the exclusion or limitation of liability for consequential or incidental damages, so the limitations above may not apply to you.</p>
<p><h2>Governing Law</h2></p>
<p>These Terms shall be governed and construed in accordance with the laws of Massachusetts, United States, without regard to its conflict of law provisions.</p>
<p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have had between us regarding the Service.</p>
<p><h2>Changes</h2></p>
<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
<p>By continuing to access or use our Service after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use the Service.</p>
<p><h2>Contact Us</h2></p>
<p>If you have any questions about these Terms, please contact us.</p>'
                    ]
                ]);

            $privacy_policy = $wsb
                ->addPage('Privacy Policy', 'privacy-policy')
                ->setAuthor('Jubair Saidi')
                ->setDescription('Plus 3 Interactive\'s Privacy Policy')
                ->setPriority('0.5')
                ->setUpdatedFrequency('yearly');

            $privacy_policy_container = $createHeaderFooterStructure($privacy_policy)
                ->addSection($block_text, 1, [
                    'content' => [
                        'content' => '<h1>Privacy Policy</h1>
<p>Last updated: January 31, 2017</p>
<p>Plus 3 Interactive, LLC (&quot;us&quot;, &quot;we&quot;, or &quot;our&quot;) operates the https://www.plus3interactive.com website (the &quot;Service&quot;).</p>
<p>This page informs you of our policies regarding the collection, use and disclosure of Personal Information when you use our Service.</p>
<p>We will not use or share your information with anyone except as described in this Privacy Policy.</p>
<p>We use your Personal Information for providing and improving the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible at https://www.plus3interactive.com</p>
<p><h2>Information Collection And Use</h2></p>
<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to, your email address, name, phone number, postal address, other information (&quot;Personal Information&quot;).
We collect this information for the purpose of providing the Service, identifying and communicating with you, responding to your requests/inquiries, servicing your purchase orders, and improving our services.</p>
<p><h2>Log Data</h2></p>
<p>We may also collect information that your browser sends whenever you visit our Service (&quot;Log Data&quot;). This Log Data may include information such as your computer\'s Internet Protocol (&quot;IP&quot;) address, browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages and other statistics.</p>
<p>In addition, we may use third party services such as Google Analytics that collect, monitor and analyze this type of information in order to increase our Service\'s functionality. These third party service providers have their own privacy policies addressing how they use such information.</p>
<p><h2>Cookies</h2></p>
<p>Cookies are files with a small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and transferred to your device. We use cookies to collect information in order to improve our services for you.</p>
<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. The Help feature on most browsers provide information on how to accept cookies, disable cookies or to notify you when receiving a new cookie.</p>
<p>If you do not accept cookies, you may not be able to use some features of our Service and we recommend that you leave them turned on.</p>
<p><h2>Do Not Track Disclosure</h2></p>
<p>We do not support Do Not Track (&quot;DNT&quot;). Do Not Track is a preference you can set in your web browser to inform websites that you do not want to be tracked.</p>
<p>You can enable or disable Do Not Track by visiting the Preferences or Settings page of your web browser.</p>
<p><h2>Service Providers</h2></p>
<p>We may employ third party companies and individuals to facilitate our Service, to provide the Service on our behalf, to perform Service-related services and/or to assist us in analyzing how our Service is used.</p>
<p>These third parties have access to your Personal Information only to perform specific tasks on our behalf and are obligated not to disclose or use your information for any other purpose.</p>
<p><h2>Communications</h2></p>
<p>We may use your Personal Information to contact you with newsletters, marketing or promotional materials and other information that may be of interest to you. You may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or instructions provided in any email we send.</p>
<p><h2>Compliance With Laws</h2></p>
<p>We will disclose your Personal Information where required to do so by law or subpoena or if we believe that such action is necessary to comply with the law and the reasonable requests of law enforcement or to protect the security or integrity of our Service.</p>
<p><h2>Security</h2></p>
<p>The security of your Personal Information is important to us, and we strive to implement and maintain reasonable, commercially acceptable security procedures and practices appropriate to the nature of the information we store, in order to protect it from unauthorized access, destruction, use, modification, or disclosure.</p>
<p>However, please be aware that no method of transmission over the internet, or method of electronic storage is 100% secure and we are unable to guarantee the absolute security of the Personal Information we have collected from you.</p>
<p><h2>International Transfer</h2></p>
<p>Your information, including Personal Information, may be transferred to — and maintained on — computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>
<p>If you are located outside United States and choose to provide information to us, please note that we transfer the information, including Personal Information, to United States and process it there.</p>
<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>
<p><h2>Links To Other Sites</h2></p>
<p>Our Service may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party\'s site. We h2ly advise you to review the Privacy Policy of every site you visit.</p>
<p>We have no control over, and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>
<p><h2>Children\'s Privacy</h2></p>
<p>Only persons age 18 or older have permission to access our Service. Our Service does not address anyone under the age of 13 (&quot;Children&quot;).</p>
<p>We do not knowingly collect personally identifiable information from children under 13. If you are a parent or guardian and you learn that your Children have provided us with Personal Information, please contact us. If we become aware that we have collected Personal Information from a children under age 13 without verification of parental consent, we take steps to remove that information from our servers.</p>
<p><h2>Changes To This Privacy Policy</h2></p>
<p>This Privacy Policy is effective as of January 31, 2017 and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.</p>
<p>We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Service after we post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.</p>
<p>If we make any material changes to this Privacy Policy, we will notify you either through the email address you have provided us, or by placing a prominent notice on our website.</p>
<p><h2>Contact Us</h2></p>
<p>If you have any questions about this Privacy Policy, please contact us.</p>'
                    ]
                ]);

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
            $terms_of_service->compilePageTemplate('public');
            $privacy_policy->compilePageTemplate('public');


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
            $main_footer_menu->addItem($terms_of_service, 7);
            $main_footer_menu->addItem($privacy_policy, 8);

            $wsb->deploy();
        })->getWebsite();

    }
}
