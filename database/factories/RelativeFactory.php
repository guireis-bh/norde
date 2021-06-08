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

$factory->define(\App\Relative::class, function (Faker $faker) {
    $user = factory(\App\User::class)->create();
    $family = factory(\App\Family::class)->create();

    return [
        'user_id' => $user->id,
        'family_id' => $family->id,
    ];
});
