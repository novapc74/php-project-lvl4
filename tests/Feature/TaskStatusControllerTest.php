<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->user = User::factory()->create();
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
        $response = $this->get(route('task_statuses.edit', [$this->taskStatus]));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = TaskStatus::factory()->make()->toArray();
        $newTaskStatus = \Arr::only($factoryData, ['name', 'description']);

        $response = $this->post(route('task_statuses.store'), $newTaskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $newTaskStatus);
    }

    public function testUpdate(): void
    {
        $newTaskStatus = \Arr::only($this->taskStatus->toArray(), ['name', 'body']);

        $response = $this->patch(route('task_statuses.update', $this->taskStatus), $newTaskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $newTaskStatus);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('task_statuses.destroy', [$this->taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
