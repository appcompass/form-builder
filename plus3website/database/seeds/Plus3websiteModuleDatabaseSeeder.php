<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\ResourceBuilder;
use P3in\Builders\SectionBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Fieldtype;
use P3in\Models\Layout;
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
        // DB::statement("TRUNCATE TABLE plus3_people RESTART IDENTITY CASCADE");
        // DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE");

        // // Imene
        // $imene = User::create([
        //     'first_name' => 'Imene',
        //     'last_name' => 'Saidi',
        //     'email' => 'imene.saidi@p3in.com',
        //     'phone' => '617-470-6003',
        //     'password' => 'd3velopment',
        //     'active' => true,
        // ]);

        // (new Plus3Person([
        //     'title' => 'Co-Founder and CEO',
        //     'meta_keywords' => 'words',
        //     'meta_description' => 'desc',
        //     'bio' => 'imene\'s Bio',
        //     'instagram' => 'imenebsaidi',
        //     'twitter' => 'imenesaidi',
        //     'facebook' => 'Imene.Saidi',
        //     'linkedin' => 'imenesaidi',
        // ]))
        //     ->user()
        //     ->associate($imene)
        //     ->save();

        // // Jubair
        // $jubair = User::create([
        //     'first_name' => 'Jubair',
        //     'last_name' => 'Saidi',
        //     'email' => 'jubair.saidi@p3in.com',
        //     'phone' => '617-755-7012',
        //     'password' => 'd3velopment',
        //     'active' => true,
        // ]);

        // (new Plus3Person([
        //     'title' => 'Co-Founder and CTO',
        //     'meta_keywords' => 'words',
        //     'meta_description' => 'desc',
        //     'bio' => 'Jubair\'s Bio',
        //     'instagram' => 'jubairsaidi',
        //     'twitter' => 'jubairsaidi',
        //     'facebook' => 'jubairsaidi',
        //     'linkedin' => 'jsaidi',
        // ]))
        //     ->user()
        //     ->associate($jubair)
        //     ->save();

        // // Aisha
        // $aisha = User::create([
        //     'first_name' => 'Aisha',
        //     'last_name' => 'Saidi',
        //     'email' => 'aisha.saidi@p3in.com',
        //     'phone' => '',
        //     'password' => 'd3velopment',
        //     'active' => true,
        // ]);

        // (new Plus3Person([
        //     'title' => 'Information Architect',
        //     'meta_keywords' => 'words',
        //     'meta_description' => 'desc',
        //     'bio' => 'aisha\'s Bio',
        //     'instagram' => '',
        //     'twitter' => '',
        //     'facebook' => '',
        //     'linkedin' => '',
        // ]))
        //     ->user()
        //     ->associate($aisha)
        //     ->save();

        // // Federico
        // $federico = User::create([
        //     'first_name' => 'Federico',
        //     'last_name' => 'Francescato',
        //     'email' => 'federico@p3in.com',
        //     'phone' => '',
        //     'password' => 'd3velopment',
        //     'active' => true,
        // ]);

        // (new Plus3Person([
        //     'title' => 'Application Developer',
        //     'meta_keywords' => 'words',
        //     'meta_description' => 'desc',
        //     'bio' => 'federico\'s Bio',
        //     'instagram' => '',
        //     'twitter' => '',
        //     'facebook' => '',
        //     'linkedin' => '',
        // ]))
        //     ->user()
        //     ->associate($federico)
        //     ->save();


        // // Lazarus
        // $lazarus = User::create([
        //     'first_name' => 'Lazarus',
        //     'last_name' => 'Morrison',
        //     'email' => 'lazarus@p3in.com',
        //     'phone' => '',
        //     'password' => 'd3velopment',
        //     'active' => true,
        // ]);

        // (new Plus3Person([
        //     'title' => 'Web Developer',
        //     'meta_keywords' => 'words',
        //     'meta_description' => 'desc',
        //     'bio' => 'lazarus\'s Bio',
        //     'instagram' => '',
        //     'twitter' => '',
        //     'facebook' => '',
        //     'linkedin' => '',
        // ]))
        //     ->user()
        //     ->associate($lazarus)
        //     ->save();

        // Website Builder API Design

        // methods with 'build' prefix return instances of what it's building, buildPage, buildMenu, etc.
        // field type ->link() allows the admin to select page || select link || create new link.
        // field validation should match exactly: https://laravel.com/docs/5.3/validation#available-validation-rules

        DB::table('websites')->where('url', 'https://www.plus3interactive.com')->delete();
        DB::table('layouts')->where('name', 'full')->delete();

        Fieldtype::firstOrCreate(['type' => 'fieldset','label' => 'Field Set']);
        Fieldtype::firstOrCreate(['type' => 'file','label' => 'File']);
        Fieldtype::firstOrCreate(['type' => 'wysiwyg','label' => 'WYSIWYG']);
        Fieldtype::firstOrCreate(['type' => 'link','label' => 'Link']);
        Fieldtype::firstOrCreate(['type' => 'pagesectionselect', 'label' => 'Page Section Select']);
        Fieldtype::firstOrCreate(['type' => 'radio', 'label' => 'Radio Selection']);
        Fieldtype::firstOrCreate(['type' => 'formbuilder', 'label' => 'Form Builder']);
        Fieldtype::firstOrCreate(['type' => 'map', 'label' => 'Map']);
        Fieldtype::firstOrCreate(['type' => 'loginform', 'label' => 'Login Form']);

        $website = WebsiteBuilder::new('Plus 3 Interactive, LLC', 'https://www.plus3interactive.com', function ($websiteBuilder) {
            $websiteBuilder->setHeader('components/Header.vue');
            $websiteBuilder->setFooter('components/Footer.vue');

            // This is here just to show how it's posssible.
            $websiteBuilder->setMetaData([
                'title' => '',
                'description' => '',
                'keywords' => '',
                'custom_header_html' => '',
                'custom_before_body_end_html' => '',
                'custom_footer_html' => '',
                'robots_txt' => '',
            ]);

            // Layouts are not website specific. We just put this here for convenience and since this setup is a single site setup.
            $full = Layout::create(['name' => 'full']);

            $slider_banner = SectionBuilder::new($full, 'Slider Banner', 'components/SliderBanner.vue', function ($formBuilder) {
                // we need to figure out how to handle the 'type' field.
                // the fields internally are created in the order they appear in the builder.
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->fieldset('Slides', 'slides', [], function ($slide) { // not field type, sub section builder.
                    $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->string('Title', 'title', ['required']);
                    $slide->wysiwyg('Description', 'description', ['required']);
                    $slide->string('Link Text', 'link_text', ['required']);
                    $slide->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            });

            $box_callouts = SectionBuilder::new($full, 'Box Callouts', 'components/BoxCallouts.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Boxes', 'boxes', [], function ($box) {
                    $box->string('Title', 'title', ['required']);
                    $box->string('Points', 'points', [])->repeatable();
                    $box->string('Link Text', 'link_text', ['required']);
                    $box->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            });

            $our_proccess = SectionBuilder::new($full, 'Our Process', 'components/OurProcess.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                // SVG Animation is static, editable in code only.
            });

            $meet_our_team = SectionBuilder::new($full, 'Meet Our Team', 'components/MeetOurTeam.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
            })
            // ->dynamic(Plus3Person::class) // we need to decide if the section is dynamic, or the field (or both can be)
            ;

            $social_stream = SectionBuilder::new($full, 'Social Stream', 'components/SocialStream.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                // Fields
            });

            $customer_testimonials = SectionBuilder::new($full, 'Customer Testimonials', 'components/CustomerTestimonials.vue', function ($formBuilder) {
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
            });

            $thick_page_banner = SectionBuilder::new($full, 'Thick Page Banner', 'components/ThickPageBanner.vue', function ($formBuilder) {
                $formBuilder->file('Background Image', 'background_image', []);
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
            });

            $white_break_w_section_links = SectionBuilder::new($full, 'White Break Callout Section Links', 'components/WhiteBreakCalloutSectionLinks.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Page Section Quick Links', 'quick_links', [], function ($quickLinks) {
                    $quickLinks->radio('Link Format', 'link_format', [
                        'ol' => 'Ordered List',
                        'ul' => 'Un Ordered List',
                        'arrow' => 'Link with Arrow'
                    ])->required();
                    $quickLinks->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                });
            });

            $provided_solution = SectionBuilder::new($full, 'Provided Solution', 'components/ProvidedSolution.vue', function ($formBuilder) {
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
            });

            $blue_break_callout = SectionBuilder::new($full, 'Blue Break Callout', 'components/BlueBreakCallout.vue', function ($formBuilder) {
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            });

            $breadcrumb_with_right_link = SectionBuilder::new($full, 'BreadCrumb With Right Side Link', 'components/BreadCrumbRightSideLink.vue', function ($formBuilder) {
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            });

            $process_timeline = SectionBuilder::new($full, 'Process Timeline', 'components/ProcessTimeline.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->fieldset('Process Steps', 'process_steps', [], function ($process) {
                    $process->file('Image File', 'image', ['type:svg']);
                    $process->string('Image width', 'image_width', []);
                    $process->string('Image Height', 'image_height', []);
                    $process->string('Title', 'title', ['required']);
                    $process->wysiwyg('Description', 'description', ['required']);
                })->repeatable();
            });

            $process_maintenance_details = SectionBuilder::new($full, 'Maintenance Details', 'components/MaintenanceDetails.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', ['required']);
                $formBuilder->wysiwyg('Description', 'description', ['required']);
                $formBuilder->file('Image File', 'image', ['type:svg']);
                $formBuilder->string('Image width', 'image_width', []);
                $formBuilder->string('Image Height', 'image_height', []);
                $formBuilder->string('Link Title', 'link_title', [])->required();
                $formBuilder->link('Link Destination', 'link_href', [])->required();
            });

            $project_list = SectionBuilder::new($full, 'Project List', 'components/ProjectList.vue', function ($formBuilder) {
                $formBuilder->fieldset('Projects', 'projects', [], function ($project) {
                    $project->file('Background Image', 'background_image', ['required']);
                    $project->file('Logo', 'logo', ['required']);
                    $project->string('Name', 'name', ['required']);
                    $project->string('Business Area', 'business_area', ['required']);
                    $project->wysiwyg('Description', 'description', ['required']);
                    $project->pageSectionSelect('Page Section Quick Links', 'quick_links', [])->repeatable();
                    $project->boolean('Highlighted', 'highlighted', ['required']);
                })->repeatable();
            });

            $contact_form = SectionBuilder::new($full, 'Contact Us', 'components/ContactUs.vue', function ($formBuilder) {
                $formBuilder->formBuilder('Contact Form', 'contact_form', []);
            });

            $map_address = SectionBuilder::new($full, 'Map Address', 'components/MapAddress.vue', function ($formBuilder) {
                $formBuilder->string('Title', 'title', []);
                $formBuilder->string('Phone Number', 'phone', []);
                $formBuilder->string('Address Line 1', 'address_1', []);
                $formBuilder->string('Address Line 2', 'address_2', []);
                $formBuilder->string('City', 'city', []);
                $formBuilder->string('State', 'state', []);
                $formBuilder->string('Zip', 'zip', []);
                $formBuilder->map('Map', 'map', ['address_1','address_2','city','state','zip']);
            });

            // We might want to consider having this section be dynamic rather than set a field to be the dynamic piece?
            // Fields: Email, Password, Remember Me
            // Links: Forgot Password
            $login_form = SectionBuilder::new($full, 'Customer Login', 'components/CustomerLogin.vue', function ($formBuilder) {
                $formBuilder->loginForm('Customer Login', 'customer_login', []);
            });

            $homeFullSections = [
                $slider_banner,
                $box_callouts,
                $our_proccess,
                $meet_our_team,
                $social_stream,
                $customer_testimonials
            ];

            $solutionsFullSections = [
                $thick_page_banner,
                $white_break_w_section_links,
                $provided_solution,
                $blue_break_callout
            ];
            $processFullSections = [
                $thick_page_banner,
                $breadcrumb_with_right_link,
                $process_timeline,
                $process_maintenance_details
            ];

            $projectsFullSections = [
                $thick_page_banner,
                $project_list,
                $blue_break_callout,
                $white_break_w_section_links
            ];

            $companyFullSections = [
                $thick_page_banner,
                $meet_our_team,
                $social_stream
            ];

            $contactFullSections = [
                $thick_page_banner,
                $contact_form,
                $map_address,
            ];

            $loginFullSections = [
                $thick_page_banner,
                $login_form,
            ];

            // Build Pages
            $homepage = $websiteBuilder
                ->buildPage('Home Page', '')
                ->setLayout($full, 1, $homeFullSections);

            $solutions = $websiteBuilder
                ->buildPage('Solutions', 'solutions')
                ->setLayout($full, 1, $solutionsFullSections);

            $process = $websiteBuilder
                ->buildPage('Our Process', 'our-process')
                ->setLayout($full, 1, $processFullSections)
                ->addParent($solutions);

            $projects = $websiteBuilder
                ->buildPage('Projects', 'projects')
                ->setLayout($full, 1, $projectsFullSections);

            $company = $websiteBuilder
                ->buildPage('Company', 'company')
                ->setLayout($full, 1, $companyFullSections);

            $contact = $websiteBuilder
                ->buildPage('Contact Us', 'contact')
                ->setLayout($full, 1, $contactFullSections);

            $login = $websiteBuilder
                ->buildPage('Customer Login', 'customer-login')
                ->setLayout($full, 1, $loginFullSections);


            $main_header_menu = $websiteBuilder->buildMenu('main_header_menu');

            $solutions_item = $main_header_menu->addItem($solutions, 1);
            $solutions_item->addItem($process, 1);

            $main_header_menu->addItem($projects, 2);
            $main_header_menu->addItem($company, 3);
            $main_header_menu->addItem($contact, 4);
            $main_header_menu->addItem($login, 5);

            $main_footer_menu = $websiteBuilder->buildMenu('main_footer_menu');
            $main_footer_menu->addItem($solutions, 1);
            $main_footer_menu->addItem($process, 2);
            $main_footer_menu->addItem($projects, 3);
            $main_footer_menu->addItem($company, 4);
            $main_footer_menu->addItem($contact, 5);
            $main_footer_menu->addItem($login, 6);

        })->getWebsite();

        // // Now lets test the magic!
        // DB::enableQueryLog();
        // $website_for_renderer = Website::find($website->id);
        // $renderer =  new PageRenderer($website_for_renderer);

        // $data = $renderer->setPage('/')->edit(); // edit() for CP, render() for public.

        // dd(DB::getQueryLog(), $data);

/*

*/
    }
}
