<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormBuilderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This only provides constraints and easy Vue components matching
        // @TODO this will be components, merge with existing one
        Schema::create('fieldtypes', function (Blueprint $table) {
            $table->string('name');
            $table->string('template'); // reference component path
            $table->primary('name');
        });

        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->nullableMorphs('formable');
            $table->string('list_layout')->default('Table'); // the list view layout [Cards, Table, MultiSelect]
            $table->string('resource')->nullable(); // point to base resource url
            // $table->string('resource')->nullable()->unique(); // point to base resource url
            $table->timestamps();

            $table->index('name');
        });

        // @NOTE Fields must belong to a form, and are unique to it
        // @TODO: look into converting to_list, to_edit, required, sortable, and searchable,
        // to attributes of a config json field (we'll end up with more options as time goes on,
        // and not all fields are created equal).  and if is null then is false can be used as a
        // only when true usage aproach.
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('label');
            $table->string('type');
            $table->json('config')->nullable();

            $table->string('validation')->nullable();

            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('fields')->onDelete('cascade');

            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');


            $table->boolean('dynamic')->default(false);

            // $table->index('name');
        });

        // @TODO consider merging this table with fields? (reason not to is already too many fields in fields)
        // @TODO: yes, merge field_sources into fields because 6 of the fields columns are config columns that can be put into a json object.
        Schema::create('field_sources', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('field_id')->unsigned()->nullable();
            // $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            // sourceable allows us to link the field to a model
            $table->nullableMorphs('sourceable');
            $table->nullableMorphs('linked'); //linked_type // linked_id
            // related field is either the field we store, or the content value we push data into
            $table->string('related_field')->nullable();
            // $table->integer('sourceable_id')->nullable();
            // $table->string('sourceable_type')->nullable();

            $table->json('data')->nullable();
            $table->json('criteria')->nullable();
        });

        // Schema::create('field_form', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('form_id')->unsigned();
        //     $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        //     $table->integer('field_id')->unsigned();
        //     $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
        //     $table->timestamps();

        //     $table->index('form_id');
        //     $table->index('field_id');

            // @NOTE About unique
            // we are using a sort of pseudo-sub-forms, allowing for parent/children relations inside form fields, this allows us to group them inside fieldsets
            // this way a dependent form does not need to be created, we just pass a parent and link all the subsequent fields to it.
            //
            // $table->unique(['form_id', 'field_id']);
        // });

        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->timestamps();

            $table->index('resource');
            $table->index('form_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('resources');
        Schema::drop('forms');
        Schema::drop('field_sources');
        Schema::drop('fields');
        Schema::drop('fieldtypes');
    }
}
