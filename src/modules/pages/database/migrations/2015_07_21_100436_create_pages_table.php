<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('title');
			$table->string('description');
			$table->json('content');
			$table->string("slug");
			$table->integer('order')->nullable();
			$table->boolean('active')->default(false);
			$table->integer('parent')->nullable();

			// $table->integer('parent')->unsigned();

			$table->integer('template_id')->unsigned();
			$table->integer('website_id')->unsigned();

			$table->string('req_permission')->nullable();
			$table->timestamp('published_at');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('template_id')
					->references('id')
					->on('templates')
					->onDelete('cascade');

			$table->foreign('website_id')
					->references('id')
					->on('websites')
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
		Schema::drop('pages');
	}
}
