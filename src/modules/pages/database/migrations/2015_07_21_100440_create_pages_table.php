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
			$table->string("slug");
			$table->integer('order')->nullable();
			$table->boolean('active')->default(false);

			$table->string('layout')->default(3)->nullable();
            $table->string('assembler_template')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
			$table->integer('website_id')->unsigned();
			$table->string('req_permission')->nullable();

            $table->foreign('parent_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');

			$table->foreign('website_id')
					->references('id')
					->on('websites')
					->onDelete('cascade');

			$table->timestamp('published_at');
			$table->timestamps();
			$table->softDeletes();
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
