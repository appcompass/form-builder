<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('storage_id')->nullable();
            $table->foreign('storage_id')->references('id')->on('storage_configs');

            $table->integer('req_perm')->unsigned()->nullable();
            $table->foreign('req_perm')->references('id')->on('permissions')->onDelete('set null');

            $table->string('name', 64);
            $table->string('scheme', 64);
            $table->string('host', 128)->unique();
            $table->json('config')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('website_redirects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('website_id')->unsigned();
            $table->string('from');
            $table->string('to');
            $table->timestamps();

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
        Schema::drop('website_redirects');
        Schema::drop('websites');
    }
}
