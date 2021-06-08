<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testGet()
    {
        $employee = factory(\App\Employee::class, 5)->create();
        $this->get('/api/employees')
            ->assertStatus(200)
            ->assertJson($employee->toArray());
    }

    public function testGetOne()
    {
        $employee = factory(\App\Employee::class)->create();
        $this->get('/api/employees/' . $employee->id)
            ->assertStatus(200)
            ->assertJson($employee->toArray());
    }

    public function testGetTeacher()
    {
        $admin = \App\EmployeeType::where('role', 'admin')->first();
        $teacher = \App\EmployeeType::where('role', 'teacher')->first();
        factory(\App\Employee::class, 3)->create([
            'type_id' => $admin->id
        ]);
        $teacher = factory(\App\Employee::class, 2)->create([
            'type_id' => $teacher->id
        ]);
        $this->get('/api/teachers')
            ->assertStatus(200)
            ->assertJson($teacher->toArray())
            ->assertJsonCount($teacher->count());
    }

    public function testPost()
    {
        $employee = factory(\App\Employee::class)->make()->toArray();
        $this->post('/api/employees', $employee)
            ->assertStatus(201)
            ->assertJson($employee);
    }

    public function testPut()
    {
        $employee = factory(\App\Employee::class)->create()->toArray();
        $employee['bank_name'] = 'Nubank';
        $this->put('/api/employees/' . $employee['id'], $employee)
            ->assertStatus(201)
            ->assertJson($employee);
    }

    public function testDelete()
    {
        $employee = factory(\App\Employee::class)->create();
        $this->delete('/api/employees/' . $employee->id)
            ->assertStatus(204);
    }

    public function testGetWithUser()
    {
        $employee = factory(\App\Employee::class)->create();
        $employee = [array_merge(
            ['user' => \App\User::find($employee->user_id)->toArray()],
            $employee->toArray()
        )];
        $this->get('/api/employees')
            ->assertStatus(200)
            ->assertJson($employee);
    }
}
