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
            'source' => '',
        ]);
        $text_field->config = [];
        $text_field->save();

        $slugify_field = Field::firstOrNew([
            'type' => 'text',
            'name' => 'slugify',
            'source' => '',
        ]);
        $slugify_field->config = [];
        $slugify_field->save();

        $password_field = Field::firstOrNew([
            'type' => 'password',
            'name' => 'password',
            'source' => '',
        ]);
        $password_field->config = [];
        $password_field->save();

        $wysiwyg_field = Field::firstOrNew([
            'type' => 'wysiwyg',
            'name' => 'wysiwyg',
            'source' => '',
        ]);
        $wysiwyg_field->config = [];
        $wysiwyg_field->save();

        $selectlist_field = Field::firstOrNew([
            'type' => 'selectlist',
            'name' => 'selectlist',
            'source' => '',
        ]);
        $selectlist_field->config = [];
        $selectlist_field->save();

        $checkbox_field = Field::firstOrNew([
            'type' => 'checkbox',
            'name' => 'checkbox',
            'source' => '',
        ]);
        $checkbox_field->config = [];
        $checkbox_field->save();

        $radio_field = Field::firstOrNew([
            'type' => 'radio',
            'name' => 'radio',
            'source' => '',
        ]);
        $radio_field->config = [];
        $radio_field->save();

        $file_field = Field::firstOrNew([
            'type' => 'file',
            'name' => 'file',
            'source' => '',
        ]);
        $file_field->config = [];
        $file_field->save();

        $textarea_field = Field::firstOrNew([
            'type' => 'textarea',
            'name' => 'textarea',
            'source' => '',
        ]);
        $textarea_field->config = [];
        $textarea_field->save();

        $datepicker_field = Field::firstOrNew([
            'type' => 'datepicker',
            'name' => 'datepicker',
            'source' => '',
        ]);
        $datepicker_field->config = [];
        $datepicker_field->save();

        Model::reguard();
    }
}
