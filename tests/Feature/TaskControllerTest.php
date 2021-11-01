<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $newStatus = Task::factory()->make()->toArray();
        $dataWithLabel = $newStatus;
        $dataWithLabel['labels'] = [null];

        $user = $this->task->createdBy;
        $response = $this->actingAs($user)
            ->post(route('tasks.store'), $dataWithLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', [$this->task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', [$this->task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $newStatus = \Arr::only($this->task->toArray(), ['name', 'description', 'status_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $this->task), $newStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', [$this->task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
