<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('parent');
            $table->string('assembler_template')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')
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
        Schema::table('pages', function ($table) {
            $table->dropForeign('pages_parent_id_foreign');
            $table->dropColumn('assembler_template');
            $table->dropColumn('parent_id');
            $table->integer('parent')->nullable();
        });
	}
}
