<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ServiceTest extends TestCase
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
        $services = \App\Service::all();

        $this->get('/api/services')
            ->assertStatus(200)
            ->assertJson($services->toArray());
    }
}
