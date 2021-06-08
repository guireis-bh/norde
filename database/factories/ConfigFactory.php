<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Config::class, function (Faker $faker) {
    $user = factory(\App\User::class)->create();
    return [
        'key' => str_replace('-', '_', $faker->slug),
        'type' => $faker->randomElement(['boolean', 'numeric', 'string']),
        'value' => $faker->realText(255),
        'user_id' => $user->id,
    ];
});
