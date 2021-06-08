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

$factory->define(\App\School::class, function (Faker $faker) {
    $address = factory(\App\Address::class)->create();
    return [
        'name' => $faker->name,
        'webpage' => $faker->url,
        'config' => 'configs',
        'address_id' => $address->id,
        'status_id' => 1,
    ];
});
