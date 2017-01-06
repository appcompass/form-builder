<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('layout_id')->nullable();
            $table->foreign('layout_id')->references('id')->on('layouts');

            $table->integer('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms');

            $table->string("name");
            $table->string("template");
            $table->string('type')->nullable();
            $table->json("config")->nullable();
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
    	Schema::drop('sections');
    }
}
