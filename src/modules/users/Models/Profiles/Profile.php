<?php

namespace P3in\Profiles;

use P3in\Models\User;
use P3in\ModularBaseModel;

class Profile extends ModularBaseModel
{
    public $table = 'profiles';

    public $fillable = [
        'name',
        'class_name'
    ];

    public static function registerProfiles($profiles)
    {
        foreach ($profiles as $name => $class_name) {
            static::firstOrCreate([
                'name' => $name,
                'class_name' => $class_name,
            ]);
        }
    }
}
