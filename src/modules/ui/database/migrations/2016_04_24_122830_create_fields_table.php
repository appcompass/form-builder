<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string("type");
            $table->string("name");
            // we use this for any fields like select lists that
            // need to fetch their records from Model.  Products, or Pages for example.
            $table->string("source")->nullable();
            $table->json('data')->nullable();
            $table->json('config')->nullable();
            $table->timestamps();
        });

        Schema::create('field_fields', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer("field_id")->unsigned();
            $table->integer("sub_field_id")->unsigned();
            $table->integer("order")->default(0);

            $table->foreign("field_id")
                ->references("id")
                ->on("fields")
                ->onDelete("cascade");

            $table->foreign("sub_field_id")
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
        Schema::drop('field_fields');
        Schema::drop('fields');
    }
}
