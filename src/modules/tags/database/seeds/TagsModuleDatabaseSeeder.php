<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TagsModuleDatabaseSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $this->call('P3in\Seeders\TagsTableSeeder');

    Model::reguard();
  }
}