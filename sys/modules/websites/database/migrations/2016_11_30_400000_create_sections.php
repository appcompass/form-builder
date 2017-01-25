<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // @TODO this will be merged with cp_fieldtypes
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name");
            $table->string("template");
            $table->string('type'); //container, section, (form?), etc?
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
