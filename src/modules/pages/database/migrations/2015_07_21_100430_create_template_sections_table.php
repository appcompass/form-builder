<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('template_sections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('section_id')->unsigned();
			$table->integer('template_id')->unsigned();

			$table->foreign('section_id')
					->references('id')
					->on('sections')
					->onDelete('cascade');

			$table->foreign('template_id')
					->references('id')
					->on('templates')
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
		Schema::table('template_sections', function( $table ) {
			$table->dropForeign("template_sections_section_id_foreign");
			$table->dropForeign("template_sections_template_id_foreign");
		});
		Schema::drop('template_section');
	}
}
