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
		// Schema::create('fields', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->string("type");
		// 	// assignign a form field name is useful in case of radio buttons.
		// 	// if the user can select which options he wants
		// 	$table->string("name");
		// 	$table->string("label");
		// 	$table->boolean('multi')->default(false);
		// 	// we use this for any fields like select lists that
		// 	// need to fetch their records from Model.  Products, or Pages for example.
		// 	$table->string("source");
		// 	$table->timestamps();
		// });

		// Schema::create('field_fields', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->integer("field_id")->unsigned();
		// 	$table->integer("sub_field_id")->unsigned();

		// 	$table->foreign("field_id")
		// 			->references("id")
		// 			->on("fields")
		// 			->onDelete("cascade");

		// 	$table->foreign("sub_field_id")
		// 			->references("id")
		// 			->on("fields")
		// 			->onDelete("cascade");
		// });

		// Schema::create('sections', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->string("name");
		// 	// does the section accept multiple instances of subsections?
		// 	// basically the question is: is it gonna get looped when rendered?
		// 	$table->boolean("multi");
		// 	$table->timestamps();
		// });

		// Schema::create('field_section', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->integer("field_id")->unsigned();
		// 	$table->integer("section_id")->unsigned();
		// 	// if the field is mandatory we don't show the possiblity to add/remove it. it's there and it's required
		// 	$table->boolean("mandatory")->default(false);

		// 	$table->foreign("field_id")
		// 			->references("id")
		// 			->on("fields")
		// 			->onDelete("cascade");

		// 	$table->foreign("section_id")
		// 			->references("id")
		// 			->on("sections")
		// 			->onDelete("cascade");
		// });

		// Schema::create('templates', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->string("name");
		// 	$table->timestamps();
		// 	$table->softDeletes();
		// });

		// Schema::create('template_section', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->integer('section_id')->unsigned();
		// 	$table->integer('template_id')->unsigned();

		// 	$table->foreign('section_id')
		// 			->references('id')
		// 			->on('sections')
		// 			->onDelete('cascade');

		// 	$table->foreign('template_id')
		// 			->references('id')
		// 			->on('templates')
		// 			->onDelete('cascade');
		// });

		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('title');
			$table->string('description');
			$table->string("slug");
			$table->integer('order')->nullable();
			$table->boolean('active')->default(false);
			$table->integer('parent')->nullable();

			// WARNING defaulting to 0 causes all sort of problems
			// $table->integer('parent')->default(0);

			// $table->integer('template_id')->unsigned();
			// $table->integer('website_id')->unsigned();

			$table->string('req_permission')->nullable();
			$table->timestamp('published_at');
			$table->timestamps();
			$table->softDeletes();

			// $table->foreign('template_id')
			// 		->references('id')
			// 		->on('templates')
			// 		->onDelete('cascade');

			// $table->foreign('website_id')
			// 		->references('id')
			// 		->on('websites')
			// 		->onDelete('cascade');
		});

		// $prefix = DB::getTablePrefix();
		// DB::statement("ALTER TABLE {$prefix}pages ADD COLUMN content JSON");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::table("field_fields", function( $table ) {
		// 	$table->dropForeign("field_fields_field_id_foreign");
		// 	$table->dropForeign("field_fields_sub_field_id_foreign");
		// });
		// Schema::drop('field_fields');

		// Schema::drop('fields');

		// Schema::table("field_section", function($table) {
		// 	$table->dropForeign("field_section_field_id_foreign");
		// 	$table->dropForeign("field_section_section_id_foreign");
		// });
		// Schema::drop('field_section');

		// Schema::table('template_section', function( $table ) {
		// 	$table->dropForeign("template_section_section_id_foreign");
		// 	$table->dropForeign("template_section_template_id_foreign");
		// });
		// Schema::drop('template_section');

		// Schema::drop('sections');

		// Schema::table('pages', function( $table ) {
		// 	$table->dropForeign('pages_template_id_foreign');
		// });

		// Schema::drop('templates');

		Schema::drop('pages');
	}
}
