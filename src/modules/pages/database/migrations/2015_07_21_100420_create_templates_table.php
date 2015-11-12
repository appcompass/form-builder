<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// we currently paused on using templates
		// i'm not deleting this migration completely because we might
		// still use it as per on discussion we had
		//

		// 	Schema::create('templates', function(Blueprint $table)
		// 	{
		// 		$table->increments('id');
		// 	});
		// }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::drop('templates');
	}
}
