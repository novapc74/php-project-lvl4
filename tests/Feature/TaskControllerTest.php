<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Arr;

class TaskControllerTest extends TestCase
{
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
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
        $factoryData = Task::factory()->make()->toArray();
        $factoryData['labels'] = [null];
        $newTask = Arr::only($factoryData, ['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newTask);
    }

    public function testShow(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', [$task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $task = Task::factory()->create();
        $factoryData = $task->toArray();
        $newStatus = Arr::only($factoryData, ['name', 'description', 'status_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $task), $newStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        if (isset($task['id'])) {
            $taskId = $task['id'];
        }
        $task->createdBy()->associate($user);
        $task->save();

        /** @var User $user */
        $response = $this->actingAs($user)
            ->delete(route('tasks.destroy', [$task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        /** @var string $taskId */
        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }
}
