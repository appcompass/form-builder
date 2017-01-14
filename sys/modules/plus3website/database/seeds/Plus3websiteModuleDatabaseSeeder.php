<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Plus3Person;
use P3in\Models\User;
use P3in\Models\ResourceBuilder;

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

/*
        // Website Builder API Design

        // methods with 'build' prefix return instances of what it's building, buildPage, buildMenu, etc.
        // field type ->href() allows the admin to select page || select link || create new link.
        // field validation should match exactly: https://laravel.com/docs/5.3/validation#available-validation-rules
        WebsiteBuilder::new('Plus 3 Interactive, LLC', 'www.plus3interactive.com'), function($websiteBuilder){

            $full = Layout::create(['name' => 'full']); // Layouts are not website specific.

            $slider_banner = SectionBuilder::new($full,'Slider Banner', 'components/SliderBanner.vue', function($sectionBuilder){
                // we need to figure out how to handle the 'type' field.
                // the fields internally are created in the order they appear in the builder.
                $sectionBuilder->text('Title', 'title', ['required']);
                $sectionBuilder->repeatable('Slides', 'slides', function($slide){ // the name on all repeatables automatically prepend the parent section's name.
                    $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->text('Title', 'title', ['required']);
                    $slide->wysiwyg('Description', 'description', ['required']);
                    $slide->text('Link Text', 'link_text', ['required']);
                    $slide->href('Link Destination', 'link_href', ['required']);
                });
            });

            $box_callouts = SectionBuilder::new($full,'Box Callouts', 'components/BoxCallouts.vue', function($sectionBuilder){
                $sectionBuilder->text('Title', 'title', ['required']);
                $sectionBuilder->wysiwyg('Description', 'description', ['required']);
                $sectionBuilder->repeatable('Boxes', 'boxes', function($box){
                    $box->text('Title', 'title', ['required']);
                    $box->repeatable('List', 'list', function($item){
                        $item->text('Title', 'title');
                    });
                    $box->text('Link Text', 'link_text', ['required']);
                    $box->href('Link Destination', 'link_href', ['required']);
                });
            });

            $our_proccess = SectionBuilder::new($full,'Our Process', 'components/OurProcess.vue', function($sectionBuilder){
                $sectionBuilder->text('Title', 'title', ['required']);
                $sectionBuilder->wysiwyg('Description', 'description', ['required']);
                // SVG Animation is static, editable in code only.
            });

            $meet_our_team = SectionBuilder::new($full,'Meet Our Team', 'components/MeetOurTeam.vue', function($sectionBuilder){
                $sectionBuilder->text('Title', 'title', ['required']);
                $sectionBuilder->wysiwyg('Description', 'description', ['required']);
                // Fields
            });

            $social_stream = SectionBuilder::new($full,'Social Stream', 'components/SocialStream.vue', function($sectionBuilder){
                $sectionBuilder->text('Title', 'title', ['required']);
                $sectionBuilder->wysiwyg('Description', 'description', ['required']);
                // Fields
            });

            $customer_testimonials = SectionBuilder::new($full,'Customer Testimonials', 'components/CustomerTestimonials.vue', function($sectionBuilder){
                $sectionBuilder->repeatable('Testimonials', 'testimonials', function($testimonial){
                    $testimonial->text('Author', 'author', ['required']);
                    $testimonial->wysiwyg('Content', 'content', ['required']);
                });
            });


            // Build Pages
            $homepage = $websiteBuilder->buildPage('Home Page', '')->addLayout($full, 1)
                 // if the section doesn't fit into any layout that is assigned to the page, it throws an error.
                // This also means it throws an error if the layout is not set.
                ->addSection($slider_banner, 1)
                ->addSection($box_callouts, 2)
                ->addSection($our_proccess, 3)
                ->addSection($meet_our_team, 4)
                ->addSection($social_stream, 5)
                ->addSection($customer_testimonials, 6)
                ;

            $solutions = $websiteBuilder->buildPage('Solutions', 'solutions')->addLayout('full');

            $process = $websiteBuilder->buildPage('Our Process', 'our-process')->addLayout('full')->addParent($solutions);

            $projects = $websiteBuilder->buildPage('Projects', 'projects')->addLayout('full');

            $company = $websiteBuilder->buildPage('Company', 'company')->addLayout('full');

            $contact = $websiteBuilder->buildPage('Contact Us', 'contact-us')->addLayout('full');

            $login = $websiteBuilder->buildPage('Customer Login', 'customer-login')->addLayout('full');


            $websiteBuilder->buildMenu('main_top_menu')
                ->addItem($solutions, 1, function($item) use ($our_process) {
                    // not sure I like the syntax of this but can't think of a better way.
                    $item->addItem($our_process, 1);
                })
                ->addItem($projects, 2)
                ->addItem($company, 3)
                ->addItem($contact_us, 4)
                ->addItem($customer_login, 5)
                ;
        });

        Structure
            Home
                Silder Banner
                    Title
                    Slides
                        Repeatable
                            Image (file)
                            Title (text)
                            Description (textarea wysiwyg)
                            Link Text
                            Link Href (select page | select link | create new link)
                Box Callouts
                    Title (text)
                    Description (textarea wysiwyg)
                    Boxes
                        Repeatable
                            Title
                            List
                                Repeatable
                                    Title
                            Link Text
                            Link Href (select page | select link | create new link)
                Our Process
                    Title (text)
                    Description (textarea wysiwyg)
                    SVG Animation (Static editable in code only)
                Meet our Team (See: Company Version)
                Social Activity Feed (See: Company Version)
                Customer Testimonials
                    Repeatable
                        Testimonial (textarea wysiwyg)
                        Testimonial Author (text)
            Solutions
                Thick Page Banner (See: Customer Login)
                White Break Callout Multiple Links
                    Title
                    Description
                    Links (See: Project Services Used)
                Provided Solution
                    Repeatable
                        Layout (left/right radio buttons)
                        Title (text)
                        Solution Photo (file)
                        Description (textarea wysiwyg)
                        Projects Using Solution (See: Project Services Used)
                        Link Description (text)
                        Link Text (text)
                        Link href (select page | select link | create new link)
                Blue Break Callout (See: Projects)
            Process
                Thick Page Banner (See: Customer Login)
                BreadCrumb Right Side Link
                    Link Text (text)
                    Link href (select page | select link | create new link)
                Process Timeline
                    Title (text)
                    Description (textarea wysiwyg)
                    Process Steps
                        Discovery
                            Title (text)
                            Content
                        Client Consultation
                            Title (text)
                            Content
                        Kick Off Meeting
                            Title (text)
                            Content
                        Information Architecture
                            Title (text)
                            Content
                        Design
                            Title (text)
                            Content
                        Front-end Development
                            Title (text)
                            Content
                        Back-end & Middleware Development
                            Title (text)
                            Content
                        Quality Assurance Testing
                            Title (text)
                            Content
                        Launch
                            Title (text)
                            Content
                    Maintenance Details
                        Title (text)
                        Description (textarea wysiwyg)
                        Link Text
                        Link Href (select page | select link | create new link)
            Projects
                Thick Page Banner (See: Customer Login)
                Project List
                    Repeatable
                        Background Photo
                        Project Logo (file)
                        Project Name (text)
                        Project Business Area (text)
                        Project Services (textarea wysiwyg)
                        Project Description (textarea wysiwyg)
                        Project Services Used (Index of Page + content_sections links)
                            Page select (dropdown)
                            Page sections (checkboxes) (only available after page selection)
                        Highlighted (boolean)
                White Break Callout Single Link
                    Title
                    Description
                    Link Text
                    Link href (select page | select link | create new link)
                Blue Break Callout
                    Link Text
                    Link href (select page | select link | create new link)
            Company
                Thick Page Banner (See: Customer Login)
                Meet our Team (Dynamic Model: Plus3Person)
                    Person Card
                        Card Photo (file)
                        Card Name (text)
                        Card Title (text)
                        Card Modal
                            Modal Photo (file - same as above)
                            Modal Name (text - same as above)
                            Modal Bio (textarea wysiwyg)
                            Modal Instagram profile (text)
                            Modal Twitter profile (text)
                            Modal Facebook profile (text)
                            Modal LinkedIn profile (text)
                Social Activity Feed
                    No Configuration per section, config provided by website settings.
            Contact Us
                Thick Page Banner (See: Customer Login)
                Contact Form (Dynamic Model: Form)
                    First Name (text)
                    Last Name (text)
                    Email (text)
                    Phone (text)
                    Company Name (text)
                    Company Website (text)
                    Your Message (textarea wysiwyg)
                Map Address
                    Map (map)
                    Title (text)
                    Address Line 1 (text)
                    Address Line 2 (text)
                    City, State Zip (text)
                    Phone Number (text)
            Customer Login
                Thick Page Banner
                    Background Image
                    Title
                    Description
                Login Form (Static Functionality: Authentication)
                    Email
                    Password
                    Remember Me
                    Forgot Password
*/

    }
}
