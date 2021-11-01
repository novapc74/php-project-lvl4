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

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
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
        TaskStatus::factory()->create();
        $task = Task::factory()->create();

        $factoryData = Task::factory()->make()->toArray();
        $factoryData['labels'] = [null];
        $newTask = \Arr::only($factoryData, ['name', 'description']);

        $response = $this->actingAs($task->createdBy)
            ->post(route('tasks.store'), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newTask);
    }

    public function testShow(): void
    {
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', [$task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $factoryData = $task->toArray();
        $newStatus = \Arr::only($factoryData, ['name', 'description', 'status_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $task), $newStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testDestroy(): void
    {
        TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', [$task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
