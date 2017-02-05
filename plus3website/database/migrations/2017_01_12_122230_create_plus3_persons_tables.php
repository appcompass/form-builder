<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlus3PersonsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This only provides constraints and easy Vue components matching
        Schema::create('plus3_people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title');
            $table->string('meta_keywords');
            $table->string('meta_description');
            $table->string('bio_summary');
            $table->string('bio');
            $table->string('cover_photo');
            $table->string('full_photo');
            $table->string('instagram');
            $table->string('twitter');
            $table->string('facebook');
            $table->string('linkedin');
            $table->boolean('public')->default(true);
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
        Schema::drop('plus3_people');
    }
}
