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
            $table->nullableMorphs('formable');
            // @TODO: is this the right place for this?  it's only applicable the index resource type.
            // $table->json('view_types')->default('["list"]'); // view types: ['list','grid','map', 'chart', 'etc'] and what ever other types a module in the future may need.
            // $table->string('create_type')->default('page'); //create types: 'page' - 'Add New' button that leads to new create view, 'dropzone' - Gallery photo upload.
            // $table->string('update_type')->default('page'); //update types: 'page' - normal full page behavior, 'modal' - modal edit view, like for a photo when clicked on a grid.
            $table->string('editor')->default('Form'); // editors: ['Menu', 'Page'] specific components we can publish from modules
            $table->timestamps();

            $table->index('name');
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('label');
            $table->string('type');
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
            $table->nullableMorphs('linked'); //linked_type // linked_id

            // related field is either the field we store, or the content value we push data into
            $table->string('related_field')->nullable();

            $table->json('data')->nullable();
            $table->json('criteria')->nullable();
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->integer('req_role')->unsigned()->nullable();
            $table->foreign('req_role')->references('id')->on('roles');
            $table->timestamps();

            $table->index('resource');
            $table->index('form_id');
        });

        Schema::create('form_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms');
            $table->json('content');
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
        Schema::drop('form_storage');
        Schema::drop('resources');
        Schema::drop('field_sources');
        Schema::drop('fields');
        Schema::drop('fieldtypes');
        Schema::drop('forms');
    }
}
