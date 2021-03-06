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

$factory->define(\App\Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->numberBetween(10, 50),
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'district' => $faker->citySuffix,
        'complement' => $faker->text(255),
        'postalcode' => $faker->postcode,
        'country' => $faker->country,
    ];
});
