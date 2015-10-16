<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->unique();
            $table->json('content')->nullable();
            $table->timestamps();
        });

        Schema::create('options_storage', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->integer('item_id');

            $table->string('option_label');
            $table->foreign('option_label')
                ->references('label')
                ->on('options')
                ->onDelete('cascade');

            $table->boolean('multi')->default('false');
            $table->integer('option_id');
            $table->index(['id', 'label']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('options_storage');
        Schema::drop('options');
    }
}