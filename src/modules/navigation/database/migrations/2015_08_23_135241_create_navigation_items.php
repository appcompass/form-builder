<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');

            $table->string('url');
            $table->boolean('new_tab')->default(false);
            $table->boolean('has_content')->default(false);
            $table->string('alt_text')->nullable();

            $table->morphs('navigatable');

            $table->string('req_perms')->nullable();
            $table->foreign('req_perms')
                ->references('type')
                ->on('permissions');

            $table->json('props')->nullable();

            $table->timestamps();
       });

        Schema::create('navigation_item_navmenu', function(Blueprint $table) {
        	$table->increments('id');

        	$table->integer('navmenu_id')->unsigned();
        	$table->integer('order')->nullable();
        	$table->foreign('navmenu_id')
        		->references('id')
        		->on('navmenus')
        		->onDelete('cascade');

        	$table->integer('navigation_item_id')->unsigned();
        	$table->foreign('navigation_item_id')
        		->references('id')
        		->on('navigation_items')
        		->onDelete('cascade');

        	$table->unique(['navigation_item_id', 'navmenu_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navigation_item_navmenu');
        Schema::drop('navigation_items');
    }
}
