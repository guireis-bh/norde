<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StudantTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $studants = factory(\App\Studant::class, 5)->create();
        $this->get('/api/studants')
            ->assertStatus(200)
            ->assertJson($studants->toArray());
    }

    public function testGetOne()
    {
        $studants = factory(\App\Studant::class)->create();
        $this->get('/api/studants/' . $studants->id)
            ->assertStatus(200)
            ->assertJson($studants->toArray());
    }

    public function testPost()
    {
        $studants = factory(\App\Studant::class)->make()->toArray();
        $this->post('/api/studants', $studants)
            ->assertStatus(201)
            ->assertJson($studants);
    }

    public function testPut()
    {
        $studant = factory(\App\Studant::class)->create()->toArray();
        $studant['calendar_color'] = '#FF0';
        $this->put('/api/studants/' . $studant['id'], $studant)
            ->assertStatus(201)
            ->assertJson($studant);
    }

    public function testDelete()
    {
        $studant = factory(\App\Studant::class)->create();
        $this->delete('/api/studants/' . $studant->id)
            ->assertStatus(204);
    }
}
