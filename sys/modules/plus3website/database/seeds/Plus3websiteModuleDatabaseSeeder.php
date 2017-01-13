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
        Sections
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
