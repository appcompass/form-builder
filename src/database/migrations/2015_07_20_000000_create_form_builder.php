<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormBuilder extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This only provides constraints and easy Vue components matching
        Schema::create('fieldtypes', function (Blueprint $table) {
            $table->string('name');
            $table->string('template'); // reference component path
            $table->primary('name');
        });

        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->json('config')->nullable();
            $table->string('editor')->default('Form'); // editors: ['Menu', 'Page'] specific components we can publish from modules
            $table->string('handler')->nullable(); // If this form requires special handling on form submission, say contact forms or really any type of form.
            $table->nullableMorphs('formable');
            $table->timestamps();

            $table->index('name');
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('label');
            $table->string('type');
            $table->foreign('type')->references('name')->on('fieldtypes')->onDelete('cascade');
            $table->boolean('to_list')->default(false); // should field show up in list view?
            $table->boolean('to_edit')->default(true); // should the field show up in edit view? default true
            $table->string('help')->nullable(); // help text
            $table->json('config')->nullable();
            $table->text('content')->nullable();
            $table->string('validation')->nullable();
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('fields')->onDelete('cascade');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->boolean('dynamic')->default(false);
        });

        Schema::create('field_sources', function (Blueprint $table) {
            $table->increments('id');
            // sourceable allows us to link the field to a model
            $table->nullableMorphs('sourceable');
            $table->integer('field_id')->nullable();
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');

            // @TODO: why polymorphic? it's always a field link.
//            $table->nullableMorphs('linked'); //linked_type // linked_id

            // related field is either the field we store, or the content value we push data into
            $table->string('related_field')->nullable();

            $table->json('data')->nullable();
            $table->json('criteria')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('field_sources');
        Schema::drop('fields');
        Schema::drop('fieldtypes');
        Schema::drop('forms');
    }
}
