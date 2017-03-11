<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('storage_id')->nullable();
            $table->foreign('storage_id')
                ->references('id')
                ->on('storage_configs');

            $table->integer('gallery_id')->unsigned();
            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->string('path')->index();
            $table->string('type');
            $table->json('meta')->nullable();
            $table->integer('order')->nullable();

            // // to use with polymorphic relationships
            // $table->morphs('photoable');

            // $table->string('status')->default('pending');

            $table->timestamps();
            $table->softDeletes();
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
    }
}
