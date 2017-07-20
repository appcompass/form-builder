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
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('req_perm')->unsigned()->nullable();
            $table->foreign('req_perm')->references('id')->on('permissions')->onDelete('set null');

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('pages');

            $table->integer('website_id')->unsigned()->nullable();
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');

            $table->integer('layout_id')->unsigned()->nullable();
            $table->foreign('layout_id')->references('id')->on('website_layouts')->onDelete('cascade');

            $table->string('slug');
            $table->string('url', 2000)->nullable(); // this is being derived automatically
            $table->string('title');
            $table->json('meta')->nullable();
            $table->boolean('dynamic_url')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['website_id', 'url']);
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
