<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("name");
			// does the section accept multiple instances of subsections?
			// basically the question is: is it gonna get looped when rendered?
			$table->boolean("multi");
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
		Schema::drop('sections');
	}
}
