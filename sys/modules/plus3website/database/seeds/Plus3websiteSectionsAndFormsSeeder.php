<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Models\Section;

class Plus3websiteSectionsAndFormsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE sections RESTART IDENTITY CASCADE');

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

        // @TODO: This one should prob be build with websites module load.
        // we should always (but only(?)) have one container component.
        // prob something we seed when loading websites module.
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
            $fb->string('Title', 'title')->validation(['required']);

            $fb->fieldset('Slides', 'slides', function (FormBuilder $slide) {
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
            // this is a Dynamic field type
            // @TODO we want a cleaner way to link it to the actual PageSectionContent
            $fb->dynamic('The Team', 'team');
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
                $testimonial->string('Author', 'author')->validation(['required']);
                $testimonial->wysiwyg('Content', 'content')->validation(['required']);
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
            $fb->radio('Link Format', 'format')->validation(['required'])->dynamic(['ol' => 'Ordered List', 'ul' => 'Un Ordered List', 'arrow' => 'Link with Arrow', ]);
            $fb->pageSectionSelect('Page Section Quick Links', 'links')->repeatable();
            // });
        })->setOwner($white_break_w_section_links);

        $provided_solution = Section::create([
            'name' => 'Provided Solution',
            'template' => 'ProvidedSolution',
            'type' => 'section'
        ]);

        FormBuilder::new('ProvidedSolution', function (FormBuilder $fb) {
            $fb->fieldset('Solution', 'solutions', function (FormBuilder $solution) {
                $solution->radio('Layout', 'layout')->validation(['required']); // @TODO DataSource , ['left' => 'Left', 'right' => 'Right']
                $solution->string('Title', 'title')->validation(['required']);
                $solution->file('Solution Photo', 'solution_photo');
                $solution->string('Solution Photo Width', 'photo_width');
                $solution->string('Solution Photo Height', 'photo_height');
                $solution->wysiwyg('Description', 'description')->validation(['required'])->validation(['required']);
                $solution->pageSectionSelect('Projects Using Solution', 'projects_using_solution')->repeatable();
                $solution->text('Link Description', 'link_description')->validation(['required']);
                $solution->string('Link Title', 'link_title')->validation(['required']);
                $solution->link('Link Destination', 'link_href')->validation(['required']);
            })->repeatable();
        })->setOwner($provided_solution);

        $blue_break_callout = Section::create([
            'name' => 'Blue Break Callout',
            'template' => 'BlueBreakCallout',
            'type' => 'section'
        ]);

        FormBuilder::new('BlueBreakCallout', function (FormBuilder $fb) {
            $fb->string('Link Title', 'link_title')->validation(['required']);
            $fb->link('Link Destination', 'link_href')->validation(['required']);
        })->setOwner($blue_break_callout);

        $breadcrumb_with_right_link = Section::create([
            'name' => 'BreadCrumb With Right Side Link',
            'template' => 'BreadCrumbRightSideLink',
            'type' => 'section'
        ]);

        FormBuilder::new('BreadCrumbRightSideLink', function (FormBuilder $fb) {
            $fb->string('Link Title', 'link_title')->validation(['required']);
            $fb->link('Link Destination', 'link_href')->validation(['required']);
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
            $fb->string('Link Title', 'link_title')->validation(['required']);
            $fb->link('Link Destination', 'link_href')->validation(['required']);
        })->setOwner($process_maintenance_details);

        $project_list = Section::create([
            'name' => 'Project List',
            'template' => 'ProjectList',
            'type' => 'section'
        ]);

        FormBuilder::new('ProjectList', function (FormBuilder $fb) {
            $fb->fieldset('Projects', 'projects', function (FormBuilder $project) {
                $project->file('Background Image', 'background_image')->validation(['required']);
                $project->file('White Logo', 'white_logo')->validation(['required']);
                $project->file('Logo', 'logo')->validation(['required']);
                $project->string('Logo Link', 'logo_link');
                $project->string('Name', 'name')->validation(['required']);
                $project->string('Business Area', 'business_area')->validation(['required']);
                $project->wysiwyg('Description', 'description')->validation(['required']);
                $project->pageSectionSelect('Page Section Quick Links', 'services_provided');
                $project->string('Link Title', 'link_title');
                $project->link('Link Destination', 'link_href');
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
                $project->file('Logo', 'logo')->validation(['required']);
                $project->string('Logo Link', 'logo_link');
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


    }
}
