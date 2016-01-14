<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxDepthToNavmenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('navmenus', function (Blueprint $table) {
            $table->integer('max_depth')->unsigned()->nullable()->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navmenus', function (Blueprint $table) {
            $table->dropColumn('max_depth');
        });
    }
}
