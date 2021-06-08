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

$factory->define(\App\Employee::class, function (Faker $faker) {
    $user = factory(\App\User::class)->create();
    $type = factory(\App\EmployeeType::class)->create();
    $salaryType = $faker->randomElement(['default', 'custom']);
    return [
        'user_id' => $user->id,
        'type_id' => $type->id,
        'bio' => $faker->text,
        'know_from' => $faker->domainName,
        'hiring_date' => $faker->date,
        'salary_type' => $salaryType,
        'salary' => $salaryType === 'custom' ? $faker->randomFloat(2) : $type->default_salary,
        'bank_name' => $faker->firstName,
        // Ajuste não ortodoxo
        'bank_office' => $faker->postcode,
        'bank_account' => $faker->postcode,
        'bank_city' => $faker->city,
    ];
});
