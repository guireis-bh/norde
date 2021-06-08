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

$factory->define(\App\EmployeeType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(60),
        'role' => substr(str_replace('-', '_', $faker->unique()->slug), 0, 60),
        'default_salary' => $faker->randomFloat(2),
    ];
});
