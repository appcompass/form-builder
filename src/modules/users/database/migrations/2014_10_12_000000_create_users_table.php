<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('phone', 24);
			$table->string('email')->unique();
			$table->string('password', 64);
			$table->boolean('active')->default(false);
			$table->string('activation_code', 64)->nullable();
			$table->timestamp('activated_at', 64)->nullable();
			$table->timestamp('last_login', 64)->nullable();
			$table->rememberToken();
			$table->timestamps();
		});

		# link permissions to user
		# naming convention: singular table name, alphabetical order, underscore to link
		Schema::create('permission_user', function(Blueprint $table) {
			$table->integer('permission_id')->unsigned()->index();
			$table->foreign('permission_id')
				    ->references('id')
				    ->on('permissions')
				    ->onDelete('cascade');

			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')
				    ->references('id')
				    ->on('users')
				    ->onDelete('cascade');

		        $table->unique(['permission_id', 'user_id']);
			$table->timestamps();
		});
	}

	//
	//
	Schema::create('profile_user', function (Blueprint $table) {
		$table->increments('id');
		$table->integer('user_id')->unsigned();
		$table->foreign('user_id')
			->references('id')
			->on('users')
			->onDelete('cascade');

		$table->integer('profilable_id')->unsigned();
		$table->integer('profilable_type');

	});

	// profilable_id = 1
	// profilable_type = \BostonPads\Models\LandlrdProfile

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
		Schema::drop('permission_user');
		Schema::drop('profile_users');
		Schema::drop('users');
	}
}
