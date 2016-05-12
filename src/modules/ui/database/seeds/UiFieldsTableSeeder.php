<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Field;

class UiFieldsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $text_field = Field::firstOrNew([
            'type' => 'text',
            'name' => 'text',
        ]);
        $text_field->save();

        $slugify_field = Field::firstOrNew([
            'type' => 'text',
            'name' => 'slugify',
        ]);
        $slugify_field->save();

        $password_field = Field::firstOrNew([
            'type' => 'password',
            'name' => 'password',
        ]);
        $password_field->save();

        $wysiwyg_field = Field::firstOrNew([
            'type' => 'wysiwyg',
            'name' => 'wysiwyg',
        ]);
        $wysiwyg_field->save();

        $selectlist_field = Field::firstOrNew([
            'type' => 'selectlist',
            'name' => 'selectlist',
        ]);
        $selectlist_field->save();

        $checkbox_field = Field::firstOrNew([
            'type' => 'checkbox',
            'name' => 'checkbox',
        ]);
        $checkbox_field->save();

        $radio_field = Field::firstOrNew([
            'type' => 'radio',
            'name' => 'radio',
        ]);
        $radio_field->save();

        $file_field = Field::firstOrNew([
            'type' => 'file',
            'name' => 'file',
        ]);
        $file_field->save();

        $textarea_field = Field::firstOrNew([
            'type' => 'textarea',
            'name' => 'textarea',
        ]);
        $textarea_field->save();

        $datepicker_field = Field::firstOrNew([
            'type' => 'datepicker',
            'name' => 'datepicker',
        ]);
        $datepicker_field->save();

        $fieldset_break_field = Field::firstOrNew([
            'type' => 'fieldset_break',
            'name' => 'fieldset_break',
        ]);
        $fieldset_break_field->save();

        // The repeatable type is usually module/form specific so this comment here is just for reference,
        // since the UI does have the capability of handling repeatables already.
        // $repeatable_field = Field::firstOrNew([
        //     'type' => 'repeatable',
        //     'name' => 'repeatable',
        // ]);
        // $repeatable_field->save();

        Model::reguard();
    }
}
