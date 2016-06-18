<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsTableIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_storage', function (Blueprint $table) {
            $table->index(['optionable_id', 'optionable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options_storage', function (Blueprint $table) {
            $table->dropIndex(['optionable_id', 'optionable_type']);
        });
    }
}
