<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Phaza\LaravelPostgis\Schema\Blueprint;

class Addresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::connection('pgsql')->table("pg_extension")->where('extname', 'postgis')->count() === 0) {
            DB::connection('pgsql')->statement('CREATE EXTENSION postgis;');
        }

        Schema::connection('pgsql')->create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('street');
            $table->string('suffix');
            $table->string('city');
            $table->string('state');
            $table->string('zip', 5);
            $table->point('location');

            // to use with polymorphic relationships
            $table->integer('addressable_id')->unsigned()->nullable();
            $table->string('addressable_type')->nullable();

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
        Schema::connection('pgsql')->drop('addresses');
    }
}
