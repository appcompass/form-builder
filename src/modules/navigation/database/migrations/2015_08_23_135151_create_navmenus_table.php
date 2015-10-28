<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navmenus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('req_perms')->nullable();

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('navmenus');

            $table->integer('website_id')->unsigned()->nullable();
            $table->foreign('website_id')->references('id')->on('websites');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navmenus');
    }
}
