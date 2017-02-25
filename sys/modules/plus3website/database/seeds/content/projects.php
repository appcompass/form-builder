<?php
return [
    'thick_page_banner' => [
        'background_image' => '',
        'title' => 'Projects',
        'description' => '<p>We find unique solutions to our clients’ unique problems through developing custom web applications, integrating proprietary systems with the modern web, and turning business ideas into web solutions. See some of our projects.</p>',
    ],
    'white_break_w_section_links' => [
        'title' => 'Our Work',
        'description' => '<p>We turn your business ideas into web solutions. Read about some of our clients:</p>',
        'format' => '',
        'links' => []
    ],
    'project_list' => [
        'projects' => [
            [
                'background_image' => '/assets/images/content/bg_project_atmgurus.jpg',
                'white_logo' => '/assets/images/content/logo_atmgurus.svg',
                'logo' => '/assets/images/content/logo_atmgurus_color.svg',
                'logo_link' => 'https://www.atmgurus.com/',
                'name' => 'ATM Gurus',
                'business_area' => 'Banking Device Repair & Training',
                'description' => '<p>We built a responsive e-commerce web application for ATM Gurus, helping their online customers easily order parts and services.</p><p>Our team integrated the web app with ATM Gurus’ backend to provide real time updates of inventory.  We also customized our proprietary application management system to allow the client to manage Web content and customer accounts.</p>',
                'services_provided' => [], // Custom Web application, Application management system, Middleware development
                'link_title' => 'For information on how we can help you, please contact us.',
                'link_href' => '/contact',
            ],[
                'background_image' => '/assets/images/content/bg_project_bostonpads.jpg',
                'white_logo' => '/assets/images/content/logo_bostonpads.svg',
                'logo' => '/assets/images/content/logo_bostonpads_color.svg',
                'logo_link' => 'http://www.bostonpads.com',
                'name' => 'BostonPads',
                'business_area' => 'Real Estate Management, Sales and Rentals',
                'description' => '<p>Boston Pads asked us to integrate their property listings data with a new, expandable web application for management of several business Web sites.</p><p>We customized our responsive, secure AMS for administration, data uploads, and editing of Web sites, as well as creation of new sites. Custom middleware populates the AMS from multiple data sources.</p>',
                'services_provided' => [], // Custom Web application, Application management system, Middleware development
                'link_title' => 'Are multiple data sources a problem for you? Please submit an RFP.',
                'link_href' => '/rfp-form',
            ],[
                'background_image' => '/assets/images/content/bg_project_versalink.jpg',
                'white_logo' => '/assets/images/content/logo_versalink.svg',
                'logo' => '/assets/images/content/logo_versalink_color.svg',
                'logo_link' => 'https://www.versasafe.com/versalink-info',
                'name' => 'VersaLink',
                'business_area' => 'Banking Devices Management and Reporting',
                'description' => '<p>VersaLink Communication System is Triton’s proprietary application for monitoring data and health of their smart safes and ATMs, via smart phone or computer.</p><p>We rebuilt VersaLink for efficiency, scalability, performance, and management of multiple devices. We also improved usability while maintaining full compatibility with previous versions.</p>',
                'services_provided' => [], // Custom Web application, Application management system, Middleware development, Device communication
                'link_title' => 'Are you juggling multiple devices? Please submit an RFP.',
                'link_href' => '/rfp-form',
            ],[
                'background_image' => '/assets/images/content/bg_project_pronto.jpg',
                'white_logo' => '/assets/images/content/logo_pronto.svg',
                'logo' => '/assets/images/content/logo_pronto_color.svg',
                'logo_link' => 'https://www.youtube.com/watch?v=INpGZPwkya4',
                'name' => 'Pronto',
                'business_area' => 'Banking Devices Management and Reporting',
                'description' => '<p>Equinox02 needed a system to manage distributors and deliveries of supplies to medical facilities. We designed an application to track deliveries, orders, refills, and cancellations. It sends status messages to facilities so patient needs are met without interruption.</p><p>We also consulted for Equinox02 on medical device communications protocols.</p>',
                'services_provided' => [], // Custom Web application, Device communication
                'link_title' => 'Do you need to communicate with your devices? Contact us.',
                'link_href' => '/contact',
            ]
        ]
    ],
    'section_heading' => [
        'title' => 'More Clients',
        'description' => '<p>text about this next section being about some of our other clients:</p>',
    ],
    'more_clients_list' => [
        'clients' => [
            [
                'logo' => '/assets/images/content/logo_level_headed.svg',
                'logo_link' => '',
                'name' => 'Level Headed Prep',
                'business_area' => 'Online education',
                // CALL TO ACTION:  [“Custom Web Application”  is link]
                // LINK:               O Solutions page and sub section
                'description' => '<p>Custom Web Application to demo viability of online student test prep, including practice tests, test results, & analytics.</p>',
            ],[
                'logo' => '/assets/images/content/logo_gpg.svg',
                'logo_link' => 'https://www.globalprofessorgroup.com',
                'name' => 'Global Professor Group',
                'business_area' => 'Online education',
                // CALL TO ACTION:  [“Custom Web Application” is link]
                // LINK:               TO Solutions page and sub section
                // CALL TO ACTION:  [“Application Management System” is link]
                // LINK:               O Solutions page and sub section
                'description' => '<p>Custom Web Application and Application Management System for online Akkadian language courses - student resources, registration, and live conference.</p>',
            ]
        ]
    ],
    'white_break_w_section_links' => [
        'title' => 'What is Plus 3 Interactive?',
        'description' => '<p>We are a small, innovative web development company that specializes in Web applications, middleware, and device communication. We also offer customization of our proprietary application management system.</p>',
        'format' => 'arrow',
        'links' => [
            [
                'text' => 'Please learn more about Plus 3 Interactive',
                'href' => '',
                //@TODO: Concept.
                'page_section' => [
                    'page_id' => 1,
                    'section_id' => 3
                ]
            ]
        ]
    ],
    'blue_break_callout' => [
        'link_title' => 'For information on how we can help you, please contact us',
        'link_href' => '/contact'
    ],
];