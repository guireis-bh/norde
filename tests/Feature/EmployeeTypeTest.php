<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EmployeeTypeTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGet()
    {
        $employeeType = \App\EmployeeType::all();

        $response = $this->get('/api/employee-types');
        $response
            ->assertStatus(200)
            ->assertJson($employeeType->toArray());
    }
}
