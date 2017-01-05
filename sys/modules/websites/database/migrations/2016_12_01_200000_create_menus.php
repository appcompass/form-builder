<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('website_id')->unsigned();
            $table->foreign('website_id')->references('id')->on('websites');

            $table->string('name');
            $table->timestamps();

            $table->integer('website_id')->unsigned();
            $table->foreign('website_id')->references('id')->on('websites');

            $table->unique(['name', 'website_id']); // just for sanity check
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
