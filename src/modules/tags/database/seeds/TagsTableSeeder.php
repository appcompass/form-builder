<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Tag;
use DB;

class TagsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tags')->delete();

    Tag::create([
      'name' => 'loft'
    ]);

    Tag::create([
      'name' => 'renewed'
    ]);
  }

}