<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->string('label');
			$table->text('description')->nullable();
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
		// Schema::table('permission_user', function( $table ) {
		// 	$table->dropForeign('permission_user_permission_id_foreign');
		// 	$table->dropForeign('permission_user_user_id_foreign');
		// });
		// Schema::drop('permission_user');

		// Schema::table('group_permission', function( $table ) {
		// 	$table->dropForeign('group_permission_group_id_foreign');
		// 	$table->dropForeign('group_permission_permission_id_foreign');
		// });
		// Schema::drop('group_permission');

		// Schema::table('permissions', function( $table ) {
		// 	$table->dropForeign('permissions_site_id_foreign');
		// });
		Schema::drop('permissions');
	}
}
