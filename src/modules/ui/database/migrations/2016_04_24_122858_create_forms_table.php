<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->json('config')->nullable();
            $table->timestamps();
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string("label");
            $table->string("name");
            $table->string("placeholder")->nullable();
            $table->string("help_block")->nullable();
            $table->json('field_attributes')->nullable();
            $table->integer("form_id")->unsigned();
            $table->integer("field_id")->unsigned();
            $table->integer("order")->default(0);

            $table->foreign("form_id")
                ->references("id")
                ->on("forms")
                ->onDelete("cascade");

            $table->foreign("field_id")
                ->references("id")
                ->on("fields")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('form_fields');
        Schema::drop('forms');
    }
}
