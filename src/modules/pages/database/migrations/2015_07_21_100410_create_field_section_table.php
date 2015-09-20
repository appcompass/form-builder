<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldSectionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('field_section', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("field_id")->unsigned();
			$table->integer("section_id")->unsigned();
			// if the field is mandatory we don't show the possibility to add/remove it. it's there and it's required
			$table->boolean("mandatory")->default(false);

			$table->foreign("field_id")
					->references("id")
					->on("fields")
					->onDelete("cascade");

			$table->foreign("section_id")
					->references("id")
					->on("sections")
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
		Schema::table("field_section", function($table) {
			$table->dropForeign("field_section_field_id_foreign");
			$table->dropForeign("field_section_section_id_foreign");
		});
		Schema::drop('field_section');
	}
}
