<?php

namespace P3in;

// use P3in\Models\Navmenu;
// use P3in\Models\Permission;
// use P3in\Models\Website;
use P3in\BaseModule;

// use P3in\Models\Profiles\Facebook;
// use P3in\Models\Profiles\Profile;

class UsersModule extends BaseModule
{


    public $module_name = 'users';

    protected $profiles = [
        // 'facebook_profile' => Facebook::class,
    ];

    public function __construct()
    {
        // \Log::info('Loading <Users> Module');
    }

    public function bootstrap()
    {
        // \Log::info('Boostrapping <Users> Module');
    }

    public function register()
    {
        // \Log::info('Registering <Users> Module');
        // Profile::registerProfiles($this->profiles);
    }

}
