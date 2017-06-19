<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteLayouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('website_id')->unsigned()->nullable();
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');

            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('website_layouts')->onDelete('cascade');

            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->json('config')->nullable();
            $table->integer('order')->unsigned()->nullable();

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
        Schema::drop('website_layouts');
    }
}
