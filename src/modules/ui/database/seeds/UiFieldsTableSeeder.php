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

        $time_field = Field::firstOrNew([
            'type' => 'selectlist',
            'name' => 'time',
        ]);
        $time_field->data = [
            '0' => '00:00',
            '1' => '01:00',
            '2' => '02:00',
            '3' => '03:00',
            '4' => '04:00',
            '5' => '05:00',
            '6' => '06:00',
            '7' => '07:00',
            '8' => '08:00',
            '9' => '09:00',
            '10' => '10:00',
            '11' => '11:00',
            '12' => '12:00',
            '13' => '13:00',
            '14' => '14:00',
            '15' => '15:00',
            '16' => '16:00',
            '17' => '17:00',
            '18' => '18:00',
            '19' => '19:00',
            '20' => '20:00',
            '21' => '21:00',
            '22' => '22:00',
            '23' => '23:00',
        ];
        $time_field->save();

        $from_to_mixed_field = Field::firstOrNew([
            'type' => 'from_to_mixed',
            'name' => 'date_and_time',
        ]);
        $from_to_mixed_field->save();
        $from_to_mixed_field->fields()->detach();

        $from_to_mixed_field->fields()->save($datepicker_field, ['order' => 1]);
        $from_to_mixed_field->fields()->save($time_field, ['order' => 2]);


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
