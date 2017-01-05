<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('url', 2083)->nullable(); // this is being derived automatically
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('meta')->nullable();
            $table->boolean('dynamic_url')->default(false);

            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('pages');

            $table->integer('website_id')->unsigned();
            $table->foreign('website_id')->references('id')->on('websites');

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
        Schema::drop('pages');
    }
}
