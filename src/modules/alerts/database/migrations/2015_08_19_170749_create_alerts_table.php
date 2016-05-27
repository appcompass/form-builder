<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('level')->default('info');
            $table->string('title');
            $table->text('message');
            $table->morphs('alertable');
            $table->json('props')->nullable();
            $table->integer('count');
            $table->string('hash', 60);
            $table->string('req_perms')->nullable(); // single permissions (go through groups)
            $table->timestamps();
        });

        Schema::create('alert_user', function() {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('alert_id')->unsigned();
            $table->foreign('alert_id')->references('id')->on('alerts');

            $table->bool('read')->default(false);
            // $table->timestamp('date_opened');@TODO not really necessary

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
        Schema::drop('alerts');
        Schema::drop('alert_user');
    }
}
