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
        TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Task::factory()->make()->toArray();
        $factoryData['labels'] = [null];
        $newTask = Arr::only($factoryData, ['name', 'description']);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->post(route('tasks.store'), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newTask);
    }

    public function testShow(): void
    {
        User::factory()->create();
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', [$task]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $factoryData = $task->toArray();
        $newStatus = Arr::only($factoryData, ['name', 'description', 'status_id']);
        /** @var User $user */
        $response = $this->actingAs($user)
            ->patch(route('tasks.update', $task), $newStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $newStatus);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $taskId = $task['id'];
        $task->createdBy()->associate($user);
        $task->save();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->delete(route('tasks.destroy', [$task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }
}
