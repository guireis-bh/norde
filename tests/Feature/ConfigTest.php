<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ConfigTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $config = factory(\App\Config::class, 5)->create();
        $this->get('/api/configs')
            ->assertStatus(200)
            ->assertJson($config->toArray());
    }

    public function testPost()
    {
        $config = factory(\App\Config::class)->make()->toArray();
        $this->post('/api/configs', $config)
            ->assertStatus(201)
            ->assertJson($config);
    }

    public function testGetUserConfigs()
    {
        $user = factory(\App\User::class)->create();
        $configs = factory(\App\Config::class, 5)->create([
            'user_id' => $user->id
        ]);
        $this->get('/api/configs/user/' . $user->id)
            ->assertStatus(200)
            ->assertJson($configs->toArray());
    }

    public function testPatch()
    {
        $user = factory(\App\User::class)->create();
        $configs = factory(\App\Config::class, 5)->make([
            'user_id' => $user
        ])->toArray();
        $this->patch('/api/configs/user/' . $user->id, $configs)
            ->assertStatus(201)
            ->assertJson($configs);
    }

    public function testPut()
    {
        $user = factory(\App\User::class)->create();
        $configs = factory(\App\Config::class, 5)->create([
            'user_id' => $user
        ])->toArray();
        $config['value'] = 'Novo valor';
        $config = $configs[random_int(0, 4)];
        $this->put('/api/configs/user/' . $user->id . '/' . $config['key'], $config)
            ->assertStatus(201)
            ->assertJson($config);
    }

    public function testDelete()
    {
        $config = factory(\App\Config::class)->create();
        $this->delete('/api/configs/' . $config->id)
            ->assertStatus(204);
    }
}
