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

            $table->string('hash', 60);
            $table->string('req_perms')->nullable(); // comma separated set of permissions

            $table->index(['hash']);

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
    }
}
