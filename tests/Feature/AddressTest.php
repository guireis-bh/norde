<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddressTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $address = factory(\App\Address::class, 5)->create();
        $this->get('/api/address')
            ->assertStatus(200)
            ->assertJson($address->toArray());
    }

    public function testGetOne()
    {
        $address = factory(\App\Address::class)->create();
        $this->get('/api/address/' . $address->id)
            ->assertStatus(200)
            ->assertJson($address->toArray());
    }

    public function testPost()
    {
        $address = factory(\App\Address::class)->make()->toArray();
        $this->post('/api/address', $address)
            ->assertStatus(201)
            ->assertJson($address);
    }

    public function testPut()
    {
        $address = factory(\App\Address::class)->create()->toArray();
        $address['street'] = 'Nascimento Silva';
        $address['number'] = '107';
        $address['city'] = 'Rio de Janeiro';
        $address['state'] = 'RJ';
        $this->put('/api/address/' . $address['id'], $address)
            ->assertStatus(201)
            ->assertJson($address);
    }

    public function testDelete()
    {
        $address = factory(\App\Address::class)->create();
        $this->delete('/api/address/' . $address->id)
            ->assertStatus(204);
    }

    public function testGetWithUser()
    {
        $user = factory(\App\User::class)->create();
        $address = [
            array_merge(
                \App\Address::find($user->address_id)->toArray(),
                ['user' => $user->toArray()]
            )
        ];
        $address[0]['number'] = (integer)$address[0]['number'];

        $this->get('/api/address')
            ->assertStatus(200)
            ->assertJson($address);
    }
}
