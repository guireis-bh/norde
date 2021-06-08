<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FamilyTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $families = factory(\App\Family::class, 5)->create();
        $numMembers = 4; 
        $families = array_map(function ($family) use($numMembers) {
            factory(\App\Studant::class, $numMembers / 2)->create([
                'family_id' => $family['id']
            ]);
            factory(\App\Relative::class, $numMembers / 2)->create([
                'family_id' => $family['id']
            ]);
            return array_merge($family, ['num_members' => $numMembers]);
        }, $families->toArray());
        
        $this->get('/api/families')
            ->assertStatus(200)
            ->assertJson($families);
    }

    public function testGetOne()
    {
        $familie = factory(\App\Family::class)->create();
        
        $this->get('/api/families/' . $familie->id)
            ->assertStatus(200)
            ->assertJson($familie->toArray());
    }

    public function testGetResponsibles()
    {
        $family = factory(\App\Family::class)->create();
        factory(\App\Relative::class, 3)->create([
            'family_id' => $family->id
        ]);
        
        $this->get('/api/families/responsibles/' . $family->id)
            ->assertStatus(200)
            ->assertJson(
                \App\Family::with('relatives.user')->find($family->id)->toArray()
            );

        $family = factory(\App\Family::class)->create();
        factory(\App\Relative::class, 3)->create([
            'family_id' => $family->id
        ]);
        $this->get('/api/families/responsibles/' . $family->id)
            ->assertStatus(200)
            ->assertJson(
                \App\Family::with('relatives.user')->find($family->id)->toArray()
            );
    }

    public function testPost()
    {
        $families = factory(\App\Family::class)->make()->toArray();
        $this->post('/api/families', $families)
            ->assertStatus(201)
            ->assertJson($families);
    }

    public function testPut()
    {
        $family = factory(\App\Family::class)->create()->toArray();
        $family['name'] = 'Familia Addans';
        $this->put('/api/families/' . $family['id'], $family)
            ->assertStatus(201)
            ->assertJson($family);
    }

    public function testDelete()
    {
        $family = factory(\App\Family::class)->create();
        $this->delete('/api/families/' . $family->id)
            ->assertStatus(204);
    }
}
