<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        #link groups to user
        # naming convention: singular table name, alphabetical order, underscore to link
        Schema::create('group_user', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')
                    ->references('id')
                    ->on('groups')
                    ->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->unique(['group_id', 'user_id']);
            $table->timestamps();
        });

        # link permissions to groups
        # naming convention: singular table name, alphabetical order, underscore to link
        // Schema::create('group_permission', function(Blueprint $table) {
        // 	$table->integer('group_id')->unsigned();
        // 	$table->foreign('group_id')
        // 		->references('id')
        // 		->on('groups')
        // 		->onDelete('cascade');

        // 	$table->integer('permission_id')->unsigned();
        // 	$table->foreign('permission_id')
        // 		->references('id')
        // 		->on('permissions')
        // 		->onDelete('cascade');

        // 	$table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('group_permission', function( $table ) {
        // 	$table->dropForeign('group_permission_group_id_foreign');
        // 	$table->dropForeign('group_permission_permission_id_foreign');
        // });
        // Schema::drop('group_permission');

        // Schema::table('group_user', function ($table) {
        //     $table->dropForeign('group_user_group_id_foreign');
        //     $table->dropForeign('group_user_user_id_foreign');
        // });

        Schema::drop('group_user');

        Schema::drop('groups');
    }
}
