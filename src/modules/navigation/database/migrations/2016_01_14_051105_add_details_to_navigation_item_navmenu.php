<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToNavigationItemNavmenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('navigation_item_navmenu', function (Blueprint $table) {

            $table->string('label')->nullable();
            $table->string('url')->nullable();
            $table->boolean('new_tab')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navigation_item_navmenu', function (Blueprint $table) {

            $table->dropColumn('label');
            $table->dropColumn('url');
            $table->dropColumn('new_tab');

        });
    }
}
