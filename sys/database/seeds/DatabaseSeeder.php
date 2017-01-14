<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Models\Gallery;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\PageContent;
use P3in\Models\PageRenderer;
use P3in\Models\Permission;
use P3in\Models\Photo;
use P3in\Models\Section;
use P3in\Models\User;
use P3in\Models\Video;
use P3in\Models\Website;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {





        // // I'm using this to stub out some data and
        // // applying the full flow to better abstract it all.
        // // I'm not attached to any part more than another,
        // // it's mainly a big brainstorm excersize.

        // DB::statement("TRUNCATE TABLE galleries RESTART IDENTITY CASCADE");
        // DB::statement("TRUNCATE TABLE settings RESTART IDENTITY CASCADE");
        // DB::statement("TRUNCATE TABLE pages RESTART IDENTITY CASCADE");
        // DB::statement("TRUNCATE TABLE sections RESTART IDENTITY CASCADE");
        // DB::statement("TRUNCATE TABLE layouts RESTART IDENTITY CASCADE");

        // // generate 20 dummy permissions
        // factory(Permission::class, 20)->create();
        // // generate 1000 dummy users and assign 3 random permissions each
        // factory(User::class, 100)->create()->each(function($user) {
        //     $user->permissions()->saveMany(Permission::inRandomOrder()->limit(3)->get());
        // });

        // // Some layouts
        // $cp_dash_system_summary_layout = Layout::create(['name' => 'cp_dash_system_summary']);
        // $cp_dash_cards_layout = Layout::create(['name' => 'cp_dash_cards']);

        // // now lets create some sections.
        // // SECTION 1
        // $cp_dash_system_summary_section = Section::create([
        //     'name' => 'CP Dashboard System Summary Bar',
        //     'template' => 'components/LayoutTypes/DashboardSystemSummary.vue', // front-end vue component,
        //                                                                       // or really anything, the backend doesn't care.
        // ])
        //     ->layout()
        //     ->associate($cp_dash_system_summary_layout);

        // $cp_dash_system_summary_section->config = [
        //     'class' => User::class, //we can also create a class specifically for output
        //                             //data (cp and/or websites, but basically for sections)
        //                             //Like in this case, we would want a CP specific class to use to handle this section method.
        //     'method' => 'latestUserActivity',
        // ];

        // $cp_dash_system_summary_section->save();

        // // SECTION 2
        // // CARD 1
        // $cp_dash_user_activity_section = Section::create([
        //     'name' => 'CP Dashboard User Activity Card',
        //     'template' => 'components/LayoutTypes/DashboardUserActivity.vue',
        // ])
        //     ->layout()
        //     ->associate($cp_dash_cards_layout);

        // $cp_dash_user_activity_section->config = [
        //     'class' => User::class,
        //     'method' => 'latestActivity',
        // ];

        // $cp_dash_user_activity_section->save();

        // // CARD 2
        // $cp_dash_gallery_activity_section = Section::create([
        //     'name' => 'CP Dashboard Gallery Activity Card',
        //     'template' => 'components/LayoutTypes/DashboardGalleryActivity.vue',
        // ])
        //     ->layout()
        //     ->associate($cp_dash_cards_layout);

        // $cp_dash_gallery_activity_section->config = [
        //     'class' => Gallery::class,
        //     'method' => 'latestActivity',
        // ];

        // $cp_dash_gallery_activity_section->save();

        // // CARD 3
        // $cp_dash_gallery_uploads_section = Section::create([
        //     'name' => 'CP Dashboard Gallery Uploads Card',
        //     'template' => 'components/LayoutTypes/DashboardGalleryUploads.vue',
        // ])
        //     ->layout()
        //     ->associate($cp_dash_cards_layout);

        // $cp_dash_gallery_uploads_section->config = [
        //     'class' => Gallery::class,
        //     'method' => 'mostUploads',
        // ];

        // $cp_dash_gallery_uploads_section->save();

        // // Get the website
        // $website =  Website::firstOrFail();

        // // lets set some arbitrary settings to test the settings functionality.
        // $website->settings = [
        //     'modules' => [
        //         'websites' => [
        //             'templates' => [
        //                 'header' => 'components/PublicWebsites/HeaderOne.vue',
        //                 'footer' => 'components/PublicWebsites/FooterOne.vue',
        //             ],
        //             'meta_data' => [
        //                 'title' => 'Default website title',
        //                 'description' => 'some random default description for the website.',
        //                 'keywords' => 'awesome cms, keywords, stuff',
        //                 'custom_header_html' => '<style>/* folks will want to overide and ineject their own html/css/js */ .hideme: { display: none; }</style>',
        //                 'robots_txt' => 'robot.txt file contents',
        //             ],
        //         ],
        //         // the below modules don't exist so it will throw an error, so they are here for now just as a concept
        //         // 'contact_forms' => [
        //         //     'from_email' => 'support@p3in.com',
        //         //     'from_name' => 'Plus 3 Support',
        //         //     'to_email' => 'reach.us@p3in.com',
        //         //     'recaptcha_key' => 'shtuff',
        //         //     'recaptcha_secret' => 'shequit!',
        //         // ],
        //         // 'google_analytics' => [
        //         //     'tracking_id' => 'UA-00000000-1',
        //         // ],
        //         // 'social' => [
        //         //     'facebook_app_id' => 'xxxxxxxxxxxx',
        //         //     'facebook_page_url' => 'https://www.facebook.com/plus3interactive',
        //         //     'twitter_page_url' => 'https://www.twitter.com/plus3interactive',
        //         //     'linkedin_page_url' => 'https://www.linkedin.com/plus3interactive',
        //         //     'instagram_page_url' => 'https://www.instagram.com/plus3interactive',
        //         //     'googleplus_page_url' => 'https://www.googleplus.com/plus3interactive',
        //         // ],
        //         // 'some_client_module' => [
        //         //     'some_setting' => 'xxxxxxxxxxxx',
        //         // ],
        //     ]
        // ];
        // $website->save();

        // // Gallery
        // $gallery = new Gallery(['name' => 'First Gallery']);
        // $user = User::first();

        // $gallery->user()->associate($user);
        // $gallery->galleryable()->associate($website);
        // $gallery->save();

        // $photo = new Photo([
        //     'path' => 'random/path.png',
        //     'status' => 'pending',
        //     'storage' => 'local',
        // ]);
        // $video = new Video([
        //     'name' => 'random video',
        //     'storage' => 'wistia',
        // ]);

        // $photo->user()->associate($user);
        // $photo->photoable()->associate($user);
        // $photo->save();

        // $video->user()->associate($user);
        // $video->videoable()->associate($user);
        // $video->save();

        // $gallery->addItem($photo, 1);
        // $gallery->addItem($video, 2);

        // // DASHBOARD PAGE
        // $dashboard = $website->pages()->create([
        //     'name' => 'Dashboard',
        //     'slug' => '',
        //     'title' => 'Dashboard',
        // ]);

        // $dashboard->layouts()->sync([
        //     $cp_dash_system_summary_layout->id => ['order' => 1],
        //     $cp_dash_cards_layout->id => ['order' => 2],
        //     // We can add more layouts if we want/need.
        // ]);

        // //The content in these 5 instances are params that are passed to the class specified in the Section.
        // //the contents of these page sections will normally be set via the CMS UI form for this section on the
        // //page where we edit this page's content (like any page in the current itteration of our CMS)
        // $cp_dash_system_summary_content = new PageContent([
        //     // in this instance, the first param is an array of the items to display and this section.
        //     // the UI would be something like a repeatable allowing you to select an icon, value, and typing in a label.
        //     // Or simply a drop down that pre-selects these 3 values, then the array of 3 would be simply an identifier of some sort.
        //     'content' => [
        //         [
        //             [
        //                 'icon' => 'cross_arrows',
        //                 'value_key' => 'total_new_users_today',
        //                 'label' => 'Total New Users',
        //             ], [
        //                 'icon' => 'card',
        //                 'value_key' => 'total_transactions_today',
        //                 'label' => 'Total Transactions Today',
        //             ], [
        //                 'icon' => 'scales',
        //                 'value_key' => 'total_sales_today',
        //                 'label' => 'Total Sales Today',
        //             ], [
        //                 'icon' => 'chart',
        //                 'value_key' => 'total_orders_today',
        //                 'label' => 'Total Orders Today',
        //             ],
        //         ],
        //     ],
        //     'order' => 1,
        // ]);
        // $cp_dash_user_activity_content = new PageContent([
        //     'content' => [20],
        //     'order' => 2,
        // ]);
        // $cp_dash_gallery_activity_content = new PageContent([
        //     'content' => [10],
        //     'order' => 3,
        // ]);
        // $cp_dash_gallery_uploads_content = new PageContent([
        //     'content' => [15],
        //     'order' => 4,
        // ]);

        // $cp_dash_system_summary_content->page()->associate($dashboard);
        // $cp_dash_system_summary_content->section()->associate($cp_dash_system_summary_section);

        // $cp_dash_user_activity_content->page()->associate($dashboard);
        // $cp_dash_user_activity_content->section()->associate($cp_dash_user_activity_section);

        // $cp_dash_gallery_activity_content->page()->associate($dashboard);
        // $cp_dash_gallery_activity_content->section()->associate($cp_dash_gallery_activity_section);

        // $cp_dash_gallery_uploads_content->page()->associate($dashboard);
        // $cp_dash_gallery_uploads_content->section()->associate($cp_dash_gallery_uploads_section);

        // $cp_dash_system_summary_content->save();
        // $cp_dash_user_activity_content->save();
        // $cp_dash_gallery_activity_content->save();
        // $cp_dash_gallery_uploads_content->save();

        // // Render the page structure.  We re fetch all the data because we want to test queries run.
        // DB::enableQueryLog();
        // $website_for_renderer = Website::find($website->id);
        // $renderer =  new PageRenderer($website_for_renderer);

        // $data = $renderer->setPage($dashboard->url)->render();

        // dd(DB::getQueryLog(), $data);
    }
}
