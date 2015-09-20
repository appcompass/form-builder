<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldFieldsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('field_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("field_id")->unsigned();
			$table->integer("sub_field_id")->unsigned();

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
		Schema::table("field_fields", function( $table ) {
			$table->dropForeign("field_fields_field_id_foreign");
			$table->dropForeign("field_fields_sub_field_id_foreign");
		});
		Schema::drop('field_fields');
	}
}
