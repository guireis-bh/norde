<?php

use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    protected $employeeTypes = [
        [
            'id' => 1,
            'name' => 'Admin',
            'role' => 'admin',
            'default_salary' => 1000.00,
        ],
        [
            'id' => 2,
            'name' => 'Supervisor',
            'role' => 'supervisor',
            'default_salary' => 600.00,
        ],
        [
            'id' => 3,
            'name' => 'Professor',
            'role' => 'teacher',
            'default_salary' => 300.00,
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->employeeTypes as $fields) {
            $employeeType = new \App\EmployeeType();
            $employeeType->id = $fields['id'];
            $employeeType->name = $fields['name'];
            $employeeType->role = $fields['role'];
            $employeeType->default_salary = $fields['default_salary'];
            $employeeType->save();
        }
    }
}
