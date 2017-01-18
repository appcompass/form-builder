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
        Schema::create('fieldtypes', function (Blueprint $table) {
            $table->string('type');
            $table->string('label');
            $table->primary('type');
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('fields')->onDelete('cascade');
            $table->boolean('to_list')->default(false); // should field show up in list view?
            $table->boolean('to_edit')->default(true); // should the field show up in edit view? default true
            $table->boolean('required')->default(false);
            $table->boolean('sortable')->default(false);
            $table->boolean('searchable')->default(false);
            $table->boolean('repeatable')->default(false);
            $table->string('validation')->nullable();

            $table->string('type');
            $table->foreign('type')
                ->references('type')
                ->on('fieldtypes')
                ->onCascade('delete');

            $table->timestamps();
            $table->index('name');
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

        Schema::create('field_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->integer('field_id')->unsigned();
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['form_id', 'field_id']);
            $table->index('form_id');
            $table->index('field_id');
        });

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
        Schema::drop('field_form');
        Schema::drop('forms');
        Schema::drop('fields');
        Schema::drop('fieldtypes');
    }
}
