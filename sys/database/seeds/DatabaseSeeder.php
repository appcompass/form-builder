<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Models\Gallery;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\PageContent;
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

        // moved this here since it's install specific.
        factory(User::class, 100)->create()->each(function ($user) {
            $user->permissions()->saveMany(Permission::inRandomOrder()->limit(3)->get());
        });

    }
}
