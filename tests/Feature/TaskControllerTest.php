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
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Task::factory()->make()->toArray();
        $factoryData['labels'] = [null];
        $task = Arr::only($factoryData, ['name', 'description']);
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post(route('tasks.store'), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $task);
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
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $factoryTask = Task::factory()->create();
        $task = $factoryTask->only(['name', 'description', 'status_id']);
        $response = $this->actingAs($user)
            ->patch(route('tasks.update', $factoryTask), $task);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $task);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $createdByUser = $user->toArray();
        $factoryTask = Task::factory()->create();
        $task = $factoryTask->toArray();
        $task['created_by_id'] = $createdByUser;
        $response = $this->actingAs($user)
            ->delete(route('tasks.destroy', [$factoryTask]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task['id']]);
    }
}
