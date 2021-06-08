<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SchoolTest extends TestCase
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
        $services = \App\School::all();

        $response = $this->get('/api/schools');
        $response
            ->assertStatus(200)
            ->assertJson($services->toArray());
    }
}
