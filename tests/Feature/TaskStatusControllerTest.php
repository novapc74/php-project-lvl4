<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\TaskStatus;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        TaskStatus::factory()->count(2)->make();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $label = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', [$label]));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = TaskStatus::factory()->make()->toArray();
        $data = \Arr::only($factoryData, ['name', 'description']);

        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $factoryData = TaskStatus::factory()->make()->toArray();
        $data = \Arr::only($factoryData, ['name', 'body']);
        $response = $this->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }
}
