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
            $table->string('label');
            $table->string('name');

            $table->string('req_perms')->nullable();

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('navmenus')
                ->onDelete('cascade');

            $table->integer('website_id')->unsigned()->nullable();
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade');

            $table->timestamps();
            $table->unique(['name', 'website_id']);
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
