<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageSectiontable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_section', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('section_id')->unsigned();
			$table->integer('page_id')->unsigned();
			$table->string('section')->nullable();
			$table->json('content')->nullable();
			$table->integer('order')->unsigned()->nullable();
			$table->string('type')->nullable();

			$table->foreign('section_id')
					->references('id')
					->on('sections')
					->onDelete('cascade');

			$table->foreign('page_id')
					->references('id')
					->on('pages')
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
		Schema::drop('page_section');
	}
}
