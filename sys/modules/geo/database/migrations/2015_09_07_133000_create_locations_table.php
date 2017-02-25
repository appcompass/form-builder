<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateLocationsTable extends Migration
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

        Schema::connection('pgsql')->create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('locationable');
            $table->point('lat_lng');
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
        Schema::connection('pgsql')->drop('locations');
    }
}
