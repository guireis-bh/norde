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

$factory->define(\App\Studant::class, function (Faker $faker) {
    $user = factory(\App\User::class)->create();
    $service = factory(\App\Service::class)->create();
    $family = factory(\App\Family::class)->create();
    $relative = factory(\App\Relative::class)->create();
    $school = factory(\App\School::class)->create();
    $teacher = factory(\App\Employee::class)->create();
    
    return [
        'user_id' => $user->id,
        'service_id' => $service->id,
        'family_id' => $family->id,
        'responsible_id' => $relative->id,
        'responsible_kinship' => $faker->randomElement(['parent', 'grandparent', 'parent_sibling', 'other']),
        'teacher_id' => $teacher->id,
        'school_id' => $school->id,
        'entry_date' => $faker->date,
        'grade' => $faker->date,
        'subject' => $faker->text(255),
        'calendar_color' => '#FFF',
        'payment_method' => $faker->randomElement(['default', 'custom']),
        'payment_value' => $faker->randomFloat(2),
        'discount' => random_int(0, 100),
    ];
});
