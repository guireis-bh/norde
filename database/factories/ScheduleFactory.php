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

$factory->define(\App\Schedule::class, function (Faker $faker) {
    $teacher = factory(\App\Employee::class)->create([
        'type_id' => 3
    ]);
    return [
        'teacher_id' => $teacher->id,
        'day' => $faker->dateTime('now')->format('Y-m-d'),
        'hour_begin' => $faker->time('i:s'),
        'hour_end' => $faker->time('i:s'),
    ];
});
