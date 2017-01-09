<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions_required', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('permission_id')->unsigned();
            $table->integer('website_id')->unsigned();
            $table->string('type'); // ['route', 'element', 'controller']
            $table->string('pointer');
            $table->timestamps();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions_required');
    }
}
