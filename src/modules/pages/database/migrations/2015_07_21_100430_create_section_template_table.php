<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionTemplateTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('section_template', function(Blueprint $table)
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
		Schema::drop('section_template');
	}
}
