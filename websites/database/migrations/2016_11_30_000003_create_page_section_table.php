<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_section', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->string('section')->nullable();
            $table->json('content')->nullable();
            $table->integer('order')->unsigned()->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('page_section');
    }
}
