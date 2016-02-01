<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleriesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('galleryable_id')->unsigned()->nullable();
            $table->string('galleryable_type')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('gallery_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('gallery_id')->unsigned();
            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('cascade');

            $table->integer('itemable_id');
            $table->string('itemable_type');
            $table->integer('order')->nullable();

            $table->unique(['gallery_id', 'itemable_id', 'itemable_type']);
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('gallery_items');
        Schema::drop('galleries');
    }

}
