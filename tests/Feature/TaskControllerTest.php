<?php

namespace Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public User $user;
    public TaskStatus $taskStatus;
    public Task $task;

    public function setUp(): void
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
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $newStatus = Task::factory()->make()->toArray();
        $dataWithLabel = $newStatus;
        $dataWithLabel['labels'] = [null];

        $response = $this->actingAs($this->task->createdBy)
            ->post(route('tasks.store'), $dataWithLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', [$this->task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->get(route('tasks.edit', [$this->task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $newStatus = \Arr::only($this->task->toArray(), ['name', 'description', 'status_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $this->task), $newStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', [$this->task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
