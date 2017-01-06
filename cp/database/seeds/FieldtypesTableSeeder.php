<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Fieldtype;
use DB;

class FieldtypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  @WARNING -> 'type' will be a Vue element, --> NOT AN HTML ELEMENT <--
        //  so beware of name collisions between Vue components and HTML elements!!!
        //  i.e. don't type a fieldtype textarea, or input
        DB::statement("TRUNCATE TABLE fieldtypes CASCADE");
        // Fieldtype::all()->remove();
        Fieldtype::create(['type' => 'string', 'label' => 'String']); // maps to text type
        Fieldtype::create(['type' => 'text', 'label' => 'Text']);
        Fieldtype::create(['type' => 'boolean', 'label' => 'Checkbox']);
        Fieldtype::create(['type' => 'radio', 'label' => 'Radio Selection']);
        Fieldtype::create(['type' => 'secret', 'label' => 'Password Field']);
        Fieldtype::create(['type' => 'datetime', 'label' => 'Datetime']);
        Fieldtype::create(['type' => 'menueditor', 'label' => 'Menu Editor']);
    }
}
