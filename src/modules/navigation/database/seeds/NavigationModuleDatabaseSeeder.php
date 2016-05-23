<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Section;
use Modular;

class NavigationModuleDatabaseSeeder extends Seeder {

	public function run()
	{
        if (Modular::isLoaded('pages')) {
            $section = Section::firstOrNew([
                'name' => 'HTML Nav',
                'fits' => 'utils',
                'display_view' => 'none',
                'edit_view' => 'none',
                'type' => 'utils',
                'config' => null
            ]);

            $section->save();

            $section->navitem(['url' => '', 'props' => ['type' => 'content_editable', 'canHaveContent' => true]])->get();

            $section = Section::firstOrNew([
                'name' => 'Latest Blog Entries',
                'fits' => 'utils',
                'display_view' => 'none',
                'edit_view' => 'none',
                'type' => 'utils',
                'config' => null
            ]);

            $section->save();

            $section->navitem(['url' => '', 'props' => ['type' => 'latest_blog_entries', 'canHaveContent' => false]])->get();

        }

	}
}