<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        $this->seed(\DatabaseSeeder::class);
    }

    public function testGet()
    {
        $user = factory(\App\User::class, 5)->create();
        $this->get('/api/users')
            ->assertStatus(200)
            ->assertJson($user->toArray());
    }

    public function testGetOne()
    {
        $user = factory(\App\User::class)->create();
        $configs = factory(\App\Config::class, 5)->create([
            'user_id' => $user->id
        ])->toArray();

        $user = array_merge(
            ['address' => \App\Address::find($user->address_id)->toArray()],
            ['configs' => $configs],
            $user->toArray()
        );
        $this->get('/api/users/' . $user['id'])
            ->assertStatus(200)
            ->assertJson($user);

    }

    public function testPost()
    {
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = 'superuser';
        $this->post('/api/users', $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));
    }

    public function testPut()
    {
        $user = factory(\App\User::class)->create()->toArray();
        $user['role'] = 'superuser';
        $user['name'] = 'Novonome';
        $this->put('/api/users/' . $user['id'], $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));
    }

    public function testDelete()
    {
        $user = factory(\App\User::class)->create();
        $this->delete('/api/users/' . $user->id)
            ->assertStatus(204);
    }

    public function testPostWithoutPassword()
    {
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = 'superuser';
        $this->post('/api/users', array_except($user, ['password']))
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));

        $this->assertDatabaseHas('configs', ['key' => 'temporary_password']);
    }

    public function testPutChangePassword()
    {
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = 'superuser';
        $this->post('/api/users', $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));
        $user = \App\User::first();
        $data = [
            'old' => $user->configs->firstWhere('key', 'temporary_password')->value,
            'password' => 'qwerty',
            'repassword' => 'qwerty'
        ];
        $this->actingAs($user, 'api')
            ->put('/api/user/change-password', $data)
            ->assertStatus(201);
        $user = \App\User::findOrFail($user->id);
        $this->assertTrue(\Hash::check('qwerty', $user->password));
    }

    public function testSendCreatedMail()
    {
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = 'superuser';
        unset($user['password']);
        $this->post('/api/users', $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));
            
        $user = \App\User::where('email', $user['email'])->first();
        Mail::fake();
        $this->get('/api/users/send-created-mail/' . $user->id)
            ->assertStatus(200);
        Mail::assertSent(\App\Mail\CreatedUser::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id &&
                $mail->hasTo($user->email);
        });
    }

    public function testPostWithSubjects()
    {
        $subjects = factory(\App\Subject::class, 3)->create()->toArray();
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = 'superuser';
        $user['subjects'] = [];
        array_map(function ($subject) use (&$user) {
            $user['subjects'][] = $subject['id'];
        }, $subjects);
        $this->post('/api/users', $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role', 'subjects']));
        $userSubjects = \App\User::first()->subjects->toArray();
        foreach($userSubjects as $key => $sub) {
            $userSubjects[$key] = array_except($sub, ['pivot', 'deleted_at']);
        }
        $this->assertEquals($userSubjects, $subjects);
    }

    public function testGetPermissions()
    {
        $this->assertPermissionFor('superuser', \RolesAndPermissionsSeeder::$permissions);
        $this->assertPermissionFor('admin', \RolesAndPermissionsSeeder::$permissions);
        $this->assertPermissionFor('supervisor', \RolesAndPermissionsSeeder::$permissions);
        $this->assertPermissionFor('teacher', []);
        $this->assertPermissionFor('relative',[]);
        $this->assertPermissionFor('studant', []);
    }

    private function assertPermissionFor($role, $permissions)
    {
        $user = factory(\App\User::class)->make()->toArray();
        $user['role'] = $role;
        $this->post('/api/users', $user)
            ->assertStatus(201)
            ->assertJson(array_except($user, ['role']));

        $user = \App\User::orderBy('created_at', 'desc')->first();
        
        $this->actingAs($user, 'api')
            ->get('/api/user/permissions')
            ->assertJson($permissions);
    }
}
