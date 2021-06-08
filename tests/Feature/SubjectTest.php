<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SubjectTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
        $this->seed(\DatabaseSeeder::class);
    }

    public function testGet()
    {
        $subject = factory(\App\Subject::class, 5)->create();
        $this->get('/api/subjects')
            ->assertStatus(200)
            ->assertJson($subject->toArray());
    }

    public function testPost()
    {
        $subject = factory(\App\Subject::class)->make()->toArray();
        $this->post('/api/subjects', $subject)
            ->assertStatus(201)
            ->assertJson($subject);
    }

    public function testPatch()
    {
        $subject = factory(\App\Subject::class, 5)->make()->toArray();
        $this->patch('/api/subjects', $subject)
            ->assertStatus(201)
            ->assertJson($subject);
    }

    public function testDelete()
    {
        $subject = factory(\App\Subject::class)->create();
        $this->delete('/api/subjects/' . $subject->id)
            ->assertStatus(204);
    }

    public function testGetByUser()
    {
        $user = factory(\App\User::class)->create();
        $subjects = factory(\App\Subject::class, 5)->create();
        foreach($subjects as $subject) {
            $user->subjects()->attach($subject);
        }
        $this->get('/api/subjects/user/' . $user->id)
            ->assertStatus(200)
            ->assertJson($subjects->toArray());
    }
}
