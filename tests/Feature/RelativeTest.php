<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use function GuzzleHttp\json_decode;

class RelativeTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $relatives = factory(\App\Relative::class, 5)->create();
        $this->get('/api/relatives')
            ->assertStatus(200)
            ->assertJson($relatives->toArray());
    }

    public function testPost()
    {
        $relatives = factory(\App\Relative::class)->make()->toArray();
        $this->post('/api/relatives', $relatives)
            ->assertStatus(201)
            ->assertJson($relatives);
    }

    public function testGetWithRelations()
    {
        $relative = factory(\App\Relative::class)->create();
        $relative = [array_merge(
            ['user' => \App\User::find($relative->user_id)->toArray()],
            ['family' => \App\Family::find($relative->family_id)->toArray()],
            $relative->toArray()
        )];
        $this->get('/api/relatives')
            ->assertStatus(200)
            ->assertJson($relative);
    }

    public function testDelete()
    {
        $relative = factory(\App\Relative::class)->create();
        $this->delete('/api/relatives/' . $relative->id)
            ->assertStatus(204);
    }
}
