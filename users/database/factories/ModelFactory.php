<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(P3in\Models\Permission::class, function (Faker $faker) {
    $word = $faker->unique()->word;
    return [
        'label' => $word,
        'type' => $word,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(P3in\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'active' => true,
        'activation_code' => str_random(64),
        'remember_token' => str_random(10)
    ];
});


// $factory->define(App\Post::class, function(Faker $faker) {
//     return [
//         'title' => $faker->sentence,
//         'user_id' => random_int(DB::table('users')->min('id'), DB::table('users')->max('id')),
//         'body' => $faker->text
//     ];
// });

// $factory->define(App\Comment::class, function(Faker $faker) {
//     return [
//         'comment' => $faker->text,
//         'user_id' => random_int(DB::table('users')->min('id'), DB::table('users')->max('id')),
//         'post_id' => random_int(DB::table('posts')->min('id'), DB::table('posts')->max('id'))
//     ];
// });
