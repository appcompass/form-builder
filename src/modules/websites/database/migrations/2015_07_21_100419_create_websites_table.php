<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('websites', function (Blueprint $table) {
			$table->increments('id');
			$table->string('site_name', 64);
			$table->string('site_url', 128);
			$table->string('from_email', 128);
			$table->string('from_name', 128);
			$table->boolean('managed')->default(false);
			$table->string('ssh_host', 128);
			$table->string('ssh_username', 128);
			$table->string('ssh_password', 256);
			$table->text('ssh_key');
			$table->string('ssh_keyphrase', 256);
			$table->string('ssh_root', 256);
			$table->json('config');
			$table->timestamp('published_at');
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
		Schema::drop('websites');
	}
}
