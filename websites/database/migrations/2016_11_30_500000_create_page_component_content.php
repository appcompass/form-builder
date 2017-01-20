<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageComponentContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_component_content', function (Blueprint $table) {
            $table->increments('id');

            // @TODO: page_id nullable?
            // we either make this nullable, or we write a tree builder for the sections
            // because otherwise when you query a page and it's components contents
            // you get a flat tree.  If we made this nullable we would have to
            // require $with = ['children']; on the PageComponentContent model
            // which would take care of our tree building automatically.
            // So the question of the day is:  do we care to have a hard link
            // to the owning page for sections since a section must and will
            // always belong to a container?
            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('page_component_content')->onDelete('cascade');

            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            $table->json('content')->nullable();
            $table->integer('columns')->unsigned();
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
        Schema::drop('page_component_content');
    }
}
