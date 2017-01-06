<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned()->nullable();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('nav_items')->onDelete('cascade');
            $table->string('label');
            $table->text('alt');
            $table->boolean('new_tab');
            $table->string('url', 2083)->nullable();
            $table->integer('order')->unsigned()->nullable();
            $table->integer('req_perm')->unsigned()->nullable();
            $table->boolean('clickable')->default(true); // sometimes we just want separators
            $table->string('icon')->nullable();
            // $table->foreign('req_perms')->references('id')->on('permissions');

            $table->integer('navigatable_id')->nullable();
            $table->string('navigatable_type')->nullable();

            $table->timestamps();

            $table->index('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nav_items');
    }
}
