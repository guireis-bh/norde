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

$factory->define(\App\ScheduleStudant::class, function (Faker $faker) {
    $schedule = factory(\App\Schedule::class)->create();
    $studant = factory(\App\Studant::class)->create();
    return [
        'schedule_id' => $schedule->id,
        'studant_id' => $studant->id,
        'time_reserved' => $faker->time('i:s'),
        'time_done' => $faker->time('i:s'),
    ];
});
