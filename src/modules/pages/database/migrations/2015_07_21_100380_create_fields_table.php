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
		Schema::create('fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("type");
			// assignign a form field name is useful in case of radio buttons.
			// if the user can select which options he wants
			$table->string("name");
			$table->string("label");
			$table->boolean('multi')->default(false);
			// we use this for any fields like select lists that
			// need to fetch their records from Model.  Products, or Pages for example.
			$table->string("source");
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
		Schema::drop('fields');
	}
}
