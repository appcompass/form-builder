<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Component;
use P3in\Models\Fieldtype;
use P3in\Models\Plus3Person;
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
        DB::statement("TRUNCATE TABLE plus3_people RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE components RESTART IDENTITY CASCADE");

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

        DB::table('websites')->where('url', 'https://www.plus3interactive.com')->delete();

        Fieldtype::firstOrCreate(['type' => 'fieldset', 'label' => 'Field Set']);
        Fieldtype::firstOrCreate(['type' => 'file', 'label' => 'File']);
        Fieldtype::firstOrCreate(['type' => 'wysiwyg', 'label' => 'WYSIWYG']);
        Fieldtype::firstOrCreate(['type' => 'link', 'label' => 'Link']);
        Fieldtype::firstOrCreate(['type' => 'pagesectionselect', 'label' => 'Page Section Select']);
        Fieldtype::firstOrCreate(['type' => 'radio', 'label' => 'Radio Selection']);
        Fieldtype::firstOrCreate(['type' => 'formbuilder', 'label' => 'Form Builder']);
        Fieldtype::firstOrCreate(['type' => 'map', 'label' => 'Map']);
        Fieldtype::firstOrCreate(['type' => 'loginform', 'label' => 'Login Form']);

        $website = WebsiteBuilder::new('Plus 3 Interactive, LLC', 'https://www.plus3interactive.com', function ($websiteBuilder) {
            $websiteBuilder->setHeader('components/Header.vue')
                ->setFooter('components/Footer.vue')
                ->setMetaData([
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                    'custom_header_html' => '',
                    'custom_before_body_end_html' => '',
                    'custom_footer_html' => '',
                    'robots_txt' => ''
                ]);
            // Build the components.

            // This one should prob be build with websites module load.
            Component::create([
                'name' => 'Container',
                'template' => 'components/container.vue', //not sure about this, do containers need templates? I feel there are good arguments for both yes and no.
                'type' => 'container',
            ]);

            $slider_banner = Component::create([
                'name' => 'Slider Banner',
                'template' => 'components/SliderBanner.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('SliderBanner', function($formBuilder) {
                // we need to figure out how to handle the 'type' field.
                // the fields internally are created in the order they appear in the builder.
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->fieldset('Slides', 'slides', [], function ($slide) {
                    // not field type, sub section builder.
                    $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->string('Title', 'title', ['required']);
                    $slide->wysiwyg('Description', 'description', ['required']);
                    $slide->string('Link Text', 'link_text', ['required']);
                    $slide->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            })->setOwner($slider_banner);

            $box_callouts = Component::create([
                'name' => 'Box Callouts',
                'template' => 'components/BoxCallouts.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('BoxCallouts', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Boxes', 'boxes', [], function ($box) {
                    $box->string('Title', 'title', ['required']);
                    $box->string('Points', 'points', [])->repeatable();
                    $box->string('Link Text', 'link_text', ['required']);
                    $box->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            })->setOwner($box_callouts);

            $our_proccess = Component::create([
                'name' => 'Our Process',
                'template' => 'components/OurProcess.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('OurProcess', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                // SVG Animation is static, editable in code only.
            })->setOwner($our_proccess);

            $meet_our_team = Component::create([
                'name' => 'Meet Our Team',
                'template' => 'components/MeetOurTeam.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('MeetOurTeam', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
            })->setOwner($meet_our_team)
            // ->dynamic(Plus3Person::class) // we need to decide if the section is dynamic, or the field (or both can be)
            ;

            $social_stream = Component::create([
                'name' => 'Social Stream',
                'template' => 'components/SocialStream.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('SocialStream', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                // Fields
            })->setOwner($social_stream);

            $customer_testimonials = Component::create([
                'name' => 'Customer Testimonials',
                'template' => 'components/CustomerTestimonials.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerTestimonials', function($formBuilder) {
                $formBuilder->fieldset('Testimonials', 'testimonials', [], function ($testimonial) {
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

            $thick_page_banner = Component::create([
                'name' => 'Thick Page Banner',
                'template' => 'components/ThickPageBanner.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('ThickPageBanner', function($formBuilder) {
                $formBuilder->file('Background Image', 'background_image', []);
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
            })->setOwner($thick_page_banner);

            $white_break_w_section_links = Component::create([
                'name' => 'White Break Callout Section Links',
                'template' => 'components/WhiteBreakCalloutSectionLinks.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('WhiteBreakCalloutSectionLinks', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Page Section Quick Links', 'quick_links', [], function ($quickLinks) {
                    $quickLinks->radio('Link Format', 'link_format', [
                        'ol' => 'Ordered List',
                        'ul' => 'Un Ordered List',
                        'arrow' => 'Link with Arrow',
                    ])->required();
                    $quickLinks->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                });
            })->setOwner($white_break_w_section_links);

            $provided_solution = Component::create([
                'name' => 'Provided Solution',
                'template' => 'components/ProvidedSolution.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('ProvidedSolution', function($formBuilder) {
                $formBuilder->fieldset('Solution', 'solution', [], function ($solution) {
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

            $blue_break_callout = Component::create([
                'name' => 'Blue Break Callout',
                'template' => 'components/BlueBreakCallout.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('BlueBreakCallout', function($formBuilder) {
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            })->setOwner($blue_break_callout);

            $breadcrumb_with_right_link = Component::create([
                'name' => 'BreadCrumb With Right Side Link',
                'template' => 'components/BreadCrumbRightSideLink.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('BreadCrumbRightSideLink', function($formBuilder) {
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            })->setOwner($breadcrumb_with_right_link);

            $process_timeline = Component::create([
                'name' => 'Process Timeline',
                'template' => 'components/ProcessTimeline.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('ProcessTimeline', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Process Steps', 'process_steps', [], function ($process) {
                    $process->file('Image File', 'image', ['type:svg']);
                    $process->string('Image width', 'image_width', []);
                    $process->string('Image Height', 'image_height', []);
                    $process->string('Title', 'title', ['required']);
                    $process->wysiwyg('Description', 'description', ['required']);
                })->repeatable();
            })->setOwner($process_timeline);

            $process_maintenance_details = Component::create([
                'name' => 'Maintenance Details',
                'template' => 'components/MaintenanceDetails.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('MaintenanceDetails', function($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->file('Image File', 'image', ['type:svg']);
                $formBuilder->string('Image width', 'image_width', []);
                $formBuilder->string('Image Height', 'image_height', []);
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            })->setOwner($process_maintenance_details);

            $project_list = Component::create([
                'name' => 'Project List',
                'template' => 'components/ProjectList.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('ProjectList', function($formBuilder) {
                $formBuilder->fieldset('Projects', 'projects', [], function ($project) {
                    $project->file('Background Image', 'background_image', ['required']);
                    $project->file('Logo', 'logo', ['required']);
                    $project->string('Name', 'name', ['required']);
                    $project->string('Business Area', 'business_area', ['required']);
                    $project->wysiwyg('Description', 'description', ['required']);
                    $project->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                    $project->boolean('Highlighted', 'highlighted', ['required']);
                })->repeatable();
            })->setOwner($project_list);

            $contact_form = Component::create([
                'name' => 'Contact Us',
                'template' => 'components/ContactUs.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('ContactUs', function($formBuilder) {
                $formBuilder->formBuilder('Contact Form', 'contact_form', []);
            })->setOwner($contact_form);

            $map_address = Component::create([
                'name' => 'Map Address',
                'template' => 'components/MapAddress.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('MapAddress', function($formBuilder) {
                $formBuilder->string('Title', 'title', []);
                $formBuilder->string('Phone Number', 'phone', []);
                $formBuilder->string('Address Line 1', 'address_1', []);
                $formBuilder->string('Address Line 2', 'address_2', []);
                $formBuilder->string('City', 'city', []);
                $formBuilder->string('State', 'state', []);
                $formBuilder->string('Zip', 'zip', []);
                $formBuilder->map('Map', 'map', ['address_1', 'address_2', 'city', 'state', 'zip']);
            })->setOwner($map_address);

            // We might want to consider having this section be dynamic rather than set a field to be the dynamic piece?
            // Fields: Email, Password, Remember Me
            // Links: Forgot Password
            $login_form = Component::create([
                'name' => 'Customer Login',
                'template' => 'components/CustomerLogin.vue',
                'type' => 'section'
            ]);

            FormBuilder::new('CustomerLogin', function($formBuilder) {
                $formBuilder->loginForm('Customer Login', 'customer_login', []);
            })->setOwner($login_form);

            // we should always (but only(?)) have one container component.
            // prob something we seed when loading websites module.



            // container->addSection
            // section->addContent

            // Build Pages
            $homepage = $websiteBuilder
                ->addPage('Home Page', '');

            $homepage_container = $homepage->addContainer(12, 1);
            $homepage_container->addSection($slider_banner, 12, 1);
            $box_callouts_container_one = $homepage_container->addContainer(6,1);
            $box_callouts_container_one->addSection($box_callouts, 6, 1);
            $box_callouts_container_two = $homepage_container->addContainer(6,2);
            $box_callouts_container_two->addSection($box_callouts, 6, 1);
            $homepage_container->addSection($our_proccess, 12, 3);
            $homepage_container->addSection($meet_our_team, 12, 4);
            $homepage_container->addSection($social_stream, 12, 5);
            $homepage_container->addSection($customer_testimonials, 12, 6);

            $solutions = $websiteBuilder
                ->addPage('Solutions', 'solutions');

            $solutions_container = $solutions->addContainer(12, 1);
            $solutions_container->addSection($thick_page_banner, 12, 1);
            $solutions_container->addSection($white_break_w_section_links, 12, 2);
            $solutions_container->addSection($provided_solution, 12, 3);
            $solutions_container->addSection($blue_break_callout, 12, 4);

            $process = $solutions
                ->addPage('Our Process', 'our-process');

            $process_container = $process->addContainer(12, 1);
            $process_container->addSection($thick_page_banner, 12, 1);
            $process_container->addSection($breadcrumb_with_right_link, 12, 2);
            $process_container->addSection($process_timeline, 12, 3);
            $process_container->addSection($process_maintenance_details, 12, 4);

            $projects = $websiteBuilder
                ->addPage('Projects', 'projects');

            $projects_container = $projects->addContainer(12, 1);
            $projects_container->addSection($thick_page_banner, 12, 1);
            $projects_container->addSection($project_list, 12, 2);
            $projects_container->addSection($blue_break_callout, 12, 3);
            $projects_container->addSection($white_break_w_section_links, 12, 4);

            $company = $websiteBuilder
                ->addPage('Company', 'company');

            $company_container = $company->addContainer(12, 1);
            $company_container->addSection($thick_page_banner, 12, 1);
            $company_container->addSection($meet_our_team, 12, 2);
            $company_container->addSection($social_stream, 12, 3);

            $contact = $websiteBuilder
                ->addPage('Contact Us', 'contact');

            $contact_container = $contact->addContainer(12, 1);
            $contact_container->addSection($thick_page_banner, 12, 1);
            $contact_container->addSection($contact_form, 12, 2);
            $contact_container->addSection($map_address, 12, 3);

            $login = $websiteBuilder
                ->addPage('Customer Login', 'customer-login');

            $login_container = $login->addContainer(12, 1);
            $login_container->addSection($thick_page_banner, 12, 1);
            $login_container->addSection($login_form, 12, 2);

            // Create the nav menus and add the items.
            $main_header_menu = $websiteBuilder->addMenu('main_header_menu');

            $solutions_item = $main_header_menu->addItem($solutions, 1);
            $solutions_item->addItem($process, 1);

            $main_header_menu->addItem($projects, 2);
            $main_header_menu->addItem($company, 3);
            $main_header_menu->addItem($contact, 4);
            $main_header_menu->addItem($login, 5);

            $main_footer_menu = $websiteBuilder->addMenu('main_footer_menu');
            $main_footer_menu->addItem($solutions, 1);
            $main_footer_menu->addItem($process, 2);
            $main_footer_menu->addItem($projects, 3);
            $main_footer_menu->addItem($company, 4);
            $main_footer_menu->addItem($contact, 5);
            $main_footer_menu->addItem($login, 6);
        })->getWebsite();

        // Now lets test the magic!
        DB::enableQueryLog();
        $website_for_renderer = Website::find($website->id);
        $renderer =  new PageRenderer($website_for_renderer);

        $data = $renderer->setPage('/')->edit(); // edit() for CP, render() for public.

        dd(DB::getQueryLog(), $data->toArray());

/*

 */
    }
}
