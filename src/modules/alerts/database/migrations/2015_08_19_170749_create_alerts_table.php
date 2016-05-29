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
            $table->text('req_perm')->nullable(); // single permission!
            $table->text('emitted_by')->default('system')->nullable();
            $table->text('channels')->default('info')->nullable;
            $table->morphs('alertable');
            $table->json('props')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
        });

        Schema::create('alert_users', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('alert_id')->unsigned();
            $table->foreign('alert_id')->references('id')->on('alerts');

            $table->boolean('read')->default(false);
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
        Schema::drop('alert_users');
        Schema::drop('alerts');
    }
}
