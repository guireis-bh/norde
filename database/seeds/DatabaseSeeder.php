<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(SchoolsSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(EmployeeTypeSeeder::class);
    }
}
