<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use P3in\Models\Section;

class AddContentToNavitem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('navigation_item_navmenu', function (Blueprint $table) {
            $table->text('content')->nullable();
            $table->json('props')->nullable();
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navigation_item_navmenu', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('props');
        });

        // we don't wanna delete those actually, using firstOrNew in up()
        // $section = Section::where('name', 'HTML nav')->delete();
        // $section = Section::where('name', 'Latest Blog Entries')->delete();

    }
}
