<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ScheduleTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGet()
    {
        $schedules = factory(\App\Schedule::class, 5)->create();
        $this->get('/api/schedules')
            ->assertStatus(200)
            ->assertJson($schedules->toArray());
    }

    public function testGetStudants()
    {
        $schedule = factory(\App\Schedule::class)->create();
        $scheduleStudants = factory(\App\ScheduleStudant::class, 2)->create([
            'schedule_id' => $schedule->id
        ]);
        $this->get("/api/schedules/{$schedule->id}/studants")
            ->assertStatus(200)
            ->assertJson($scheduleStudants->toArray());
    }

    public function testGetOne()
    {
        $schedules = factory(\App\Schedule::class)->create();
        $this->get("/api/schedules/{$schedules->id}")
            ->assertStatus(200)
            ->assertJson($schedules->toArray());
    }

    public function testGetStudantOne()
    {
        $schedule = factory(\App\Schedule::class)->create();
        $scheduleStudants = factory(\App\ScheduleStudant::class)->create([
            'schedule_id' => $schedule->id
        ]);
        $this->get("/api/schedules/studant/{$scheduleStudants->id}")
            ->assertStatus(200)
            ->assertJson($scheduleStudants->toArray());
    }

    public function testPost()
    {
        $schedules = factory(\App\Schedule::class)->make()->toArray();
        $this->post('/api/schedules', $schedules)
            ->assertStatus(201)
            ->assertJson($schedules);
    }

    public function testPostStudant()
    {
        $scheduleStudant = array_except(
            factory(\App\ScheduleStudant::class)->make()->toArray(),
            ['time_done']
        );
        $this->post(
                "/api/schedules/{$scheduleStudant['schedule_id']}/studant",
                $scheduleStudant
            )
            ->assertStatus(201)
            ->assertJson($scheduleStudant);
    }

    public function testPut()
    {
        $studant = factory(\App\Schedule::class)->create()->toArray();
        $this->put("/api/schedules/{$studant['id']}", $studant)
            ->assertStatus(201)
            ->assertJson($studant);
    }

    public function testPutStudant()
    {
        $scheduleStudant = factory(\App\ScheduleStudant::class)->create()->toArray();
        $this->put(
                "/api/schedules/studant/{$scheduleStudant['id']}",
                array_only($scheduleStudant, ['time_done'])
            )
            ->assertStatus(201)
            ->assertJson($scheduleStudant);
    }

    public function testDelete()
    {
        $schedule = factory(\App\Schedule::class)->create();
        $this->delete("/api/schedules/{$schedule->id}")
            ->assertStatus(204);
    }

    public function testDeleteStudant()
    {
        $scheduleStudant = factory(\App\ScheduleStudant::class)->create();
        $this->delete("/api/schedules/studant/{$scheduleStudant->id}")
            ->assertStatus(204);
    }
}
